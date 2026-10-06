/* Search palette + music player. Plain JS, no dependencies. */

const scrollLock = {
  stop(){ window.__scroll && window.__scroll.stop(); },
  start(){ window.__scroll && window.__scroll.start(); }
};
function store(key, value){
  try {
    if(value === undefined) return JSON.parse(localStorage.getItem(key) || 'null');
    localStorage.setItem(key, JSON.stringify(value));
  } catch(e){ return null; }
}

/* ================= THEME ================= */
(function theme(){
  const root = document.documentElement;
  const btn = document.getElementById('theme-toggle');
  function apply(t){ root.setAttribute('data-theme', t); }
  if(btn) btn.addEventListener('click', () => {
    const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    apply(next);
    try { localStorage.setItem('theme', next); } catch(e){}
  });
  // Follow the system setting until the visitor picks a theme by hand.
  const mq = window.matchMedia('(prefers-color-scheme: dark)');
  if(mq.addEventListener) mq.addEventListener('change', e => { let saved = null; try { saved = localStorage.getItem('theme'); } catch(_){} if(!saved) apply(e.matches ? 'dark' : 'light'); });
})();

/* ================= SEARCH ================= */
(function search(){
  const root = document.getElementById('search');
  if(!root) return;
  const input = document.getElementById('search-input');
  const list = document.getElementById('search-results');
  const empty = document.getElementById('search-empty');
  const types = JSON.parse(root.dataset.types || '{}');
  let index = null, loading = null, active = 0, shown = [];

  function load(){
    if(index) return Promise.resolve(index);
    if(!loading){
      loading = fetch(root.dataset.src, { headers: { Accept: 'application/json' } })
        .then(r => r.json())
        .then(data => { index = data.map(i => ({ ...i, hay: (i.t + ' ' + i.d + ' ' + i.x).toLowerCase(), tl: i.t.toLowerCase() })); return index; })
        .catch(() => { loading = null; return []; });
    }
    return loading;
  }

  function query(q){
    const tokens = q.toLowerCase().split(/\s+/).filter(Boolean);
    if(!tokens.length) return index.slice(0, 9);
    return index
      .map((item, pos) => {
        let score = 0;
        for(const t of tokens){
          if(item.tl.startsWith(t)) score += 4;
          else if(item.tl.includes(t)) score += 3;
          else if(item.hay.includes(t)) score += 1;
          else return null;
        }
        return { item, score, pos };
      })
      .filter(Boolean)
      .sort((a, b) => b.score - a.score || a.pos - b.pos)
      .slice(0, 12)
      .map(x => x.item);
  }

  function setActive(i){
    active = Math.max(0, Math.min(i, shown.length - 1));
    [...list.children].forEach((li, n) => {
      const on = n === active;
      li.classList.toggle('on', on);
      li.setAttribute('aria-selected', on ? 'true' : 'false');
      if(on) li.scrollIntoView({ block: 'nearest' });
    });
  }

  function render(){
    const q = input.value.trim();
    shown = index ? query(q) : [];
    list.textContent = '';
    shown.forEach((item, n) => {
      const li = document.createElement('li');
      li.setAttribute('role', 'option');
      const a = document.createElement('a');
      a.href = item.u;
      const body = document.createElement('span'); body.className = 'search-item-body';
      const t = document.createElement('span'); t.className = 'search-item-title'; t.textContent = item.t;
      const d = document.createElement('span'); d.className = 'search-item-desc'; d.textContent = item.d;
      body.append(t, d);
      const k = document.createElement('span'); k.className = 'search-item-type'; k.textContent = types[item.k] || item.k;
      a.append(body, k);
      li.append(a);
      li.addEventListener('mousemove', () => { if(active !== n) setActive(n); });
      list.append(li);
    });
    empty.hidden = shown.length > 0 || !index;
    if(!shown.length && index) empty.textContent = q ? root.dataset.empty + ' “' + q + '”' : root.dataset.hint;
    setActive(0);
  }

  function open(){
    if(!root.hidden) return;
    root.hidden = false;
    scrollLock.stop();
    document.addEventListener('keydown', onKey);
    input.value = '';
    empty.hidden = false; empty.textContent = root.dataset.loading;
    load().then(() => { render(); });
    setTimeout(() => input.focus(), 30);
  }
  function close(){
    if(root.hidden) return;
    root.hidden = true;
    scrollLock.start();
    document.removeEventListener('keydown', onKey);
  }
  function onKey(e){
    if(e.key === 'Escape'){ e.preventDefault(); close(); }
    else if(e.key === 'ArrowDown'){ e.preventDefault(); setActive(active + 1); }
    else if(e.key === 'ArrowUp'){ e.preventDefault(); setActive(active - 1); }
    else if(e.key === 'Enter' && shown[active]){ e.preventDefault(); window.location.href = shown[active].u; }
  }

  input.addEventListener('input', render);
  document.getElementById('search-close').addEventListener('click', close);
  root.addEventListener('click', e => { if(e.target === root) close(); });
  list.addEventListener('click', () => close());
  if(/Mac|iPhone|iPad/.test(navigator.platform || navigator.userAgent)) document.querySelectorAll('.search-kbd').forEach(k => { k.textContent = '⌘ K'; });
  document.querySelectorAll('[data-open-search]').forEach(b => b.addEventListener('click', open));
  document.addEventListener('keydown', e => {
    if((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k'){ e.preventDefault(); root.hidden ? open() : close(); }
  });
})();

/* ================= MUSIC PLAYER ================= */
(function player(){
  const root = document.getElementById('player');
  if(!root) return;
  const channels = JSON.parse(root.dataset.channels);
  const audio = document.getElementById('player-audio');
  const toggle = document.getElementById('player-toggle');
  const info = document.getElementById('player-info');
  const panel = document.getElementById('player-panel');
  const stateEl = document.getElementById('player-state');
  const nameEl = document.getElementById('player-name');
  const muteBtn = document.getElementById('player-mute');
  const L = k => root.dataset['l' + k[0].toUpperCase() + k.slice(1)];

  const saved = store('player') || {};
  let current = channels.find(c => c.id === saved.ch) || channels[0];
  let wantPlaying = false;
  audio.muted = !!saved.muted;

  function persist(){ store('player', { ch: current.id, playing: wantPlaying, muted: audio.muted }); }

  function paint(state){
    root.dataset.state = state;
    const playing = state === 'playing' || state === 'loading';
    toggle.setAttribute('aria-label', playing ? L('pause') : L('play'));
    stateEl.textContent = state === 'playing' ? L('now') : state === 'loading' ? L('loading') : state === 'error' ? L('error') : L('paused');
    nameEl.textContent = current.icon + ' ' + current.name;
    root.querySelectorAll('.player-ch').forEach(b => b.classList.toggle('on', b.dataset.ch === current.id));
    muteBtn.classList.toggle('is-muted', audio.muted);
    muteBtn.setAttribute('aria-label', audio.muted ? L('unmute') : L('mute'));
  }

  function play(){
    wantPlaying = true;
    // Live streams: always reload so playback resumes at "now", not at stale buffered audio.
    audio.src = current.url;
    paint('loading');
    const p = audio.play();
    if(p && p.catch) p.catch(() => { wantPlaying = false; paint('paused'); persist(); });
    persist();
  }
  function pause(){
    wantPlaying = false;
    audio.pause();
    audio.removeAttribute('src');
    audio.load();
    paint('paused');
    persist();
  }

  toggle.addEventListener('click', () => (wantPlaying ? pause() : play()));
  muteBtn.addEventListener('click', () => { audio.muted = !audio.muted; paint(root.dataset.state || 'paused'); persist(); });

  root.querySelectorAll('.player-ch').forEach(btn => btn.addEventListener('click', () => {
    current = channels.find(c => c.id === btn.dataset.ch) || current;
    play();
    closePanel();
  }));

  function openPanel(){ panel.hidden = false; info.setAttribute('aria-expanded', 'true'); root.classList.add('open'); }
  function closePanel(){ panel.hidden = true; info.setAttribute('aria-expanded', 'false'); root.classList.remove('open'); }
  info.addEventListener('click', () => (panel.hidden ? openPanel() : closePanel()));
  document.addEventListener('click', e => { if(!panel.hidden && !root.contains(e.target)) closePanel(); });
  document.addEventListener('keydown', e => { if(e.key === 'Escape' && !panel.hidden) closePanel(); });

  audio.addEventListener('playing', () => paint('playing'));
  audio.addEventListener('waiting', () => { if(wantPlaying) paint('loading'); });
  audio.addEventListener('error', () => { if(wantPlaying){ wantPlaying = false; paint('error'); persist(); } });

  paint('paused');
  // Pages are full loads, so try to resume what was playing; browsers may block it until the next tap.
  if(saved.playing){
    wantPlaying = true;
    audio.src = current.url;
    paint('loading');
    const p = audio.play();
    if(p && p.catch) p.catch(() => { wantPlaying = false; audio.removeAttribute('src'); paint('paused'); });
  }
})();
