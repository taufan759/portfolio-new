import Lenis from 'lenis';

/* ================= ADAPTIVE GRID ================= */
function applyAdaptiveGrid(){
  const FONT_BASE = 16, baseWidth = 1920, coef = 0.6666;
  const w = window.innerWidth;
  const widthReduction = ((baseWidth - w) / baseWidth) * 100;
  const size = FONT_BASE - (FONT_BASE * (widthReduction * coef)) / 100;
  if (size > FONT_BASE) document.documentElement.style.fontSize = size + 'px';
  else document.documentElement.style.removeProperty('font-size');
}
applyAdaptiveGrid();
addEventListener('resize', applyAdaptiveGrid);

/* ================= LENIS ================= */
window.scrollTo(0, 0);
const lenis = new Lenis({ smoothWheel: true });
function raf(t){ lenis.raf(t); requestAnimationFrame(raf); }
requestAnimationFrame(raf);

/* ================= HEADER ================= */
const siteHeader = document.getElementById('site-header');
function updateHeader(){ siteHeader.classList.toggle('scrolled', window.scrollY > 24); }
updateHeader();
addEventListener('scroll', updateHeader, { passive: true });

/* ================= SCROLL LOCK ================= */
let scrollEnabled = true;
function stopScroll(){
  if(!scrollEnabled) return;
  scrollEnabled = false;
  lenis.stop();
  document.documentElement.style.position = 'relative';
  document.documentElement.style.overflow = 'hidden';
  document.documentElement.style.height = '100%';
}
function startScroll(){
  scrollEnabled = true;
  lenis.start();
  document.documentElement.style.removeProperty('position');
  document.documentElement.style.removeProperty('overflow');
  document.documentElement.style.removeProperty('height');
}

window.__scroll = { stop: stopScroll, start: startScroll };

function scrollToId(id){
  const el = document.getElementById(id);
  if(!el) return;
  const wasEnabled = scrollEnabled;
  if(wasEnabled) lenis.stop();
  setTimeout(()=>{
    const top = el.getBoundingClientRect().top + window.pageYOffset;
    window.scrollTo({ top, behavior: 'smooth' });
  }, 50);
  setTimeout(()=>{ if(wasEnabled) lenis.start(); }, 100);
}

/* ================= LOADER ================= */
let loader = document.getElementById('loader');
try {
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(loader && (reducedMotion || sessionStorage.getItem('loaderSeen'))){ loader.remove(); loader = null; }
  else if(loader){ sessionStorage.setItem('loaderSeen','1'); }
} catch(e){}
const loaderFill = document.getElementById('loader-fill');
const loaderCount = document.getElementById('loader-count');
let introReady = false;
const heroReadyCallbacks = [];

const FILL_MS = 1300;
function easeInOutCubic(t){ return t < 0.5 ? 4*t*t*t : 1-Math.pow(-2*t+2,3)/2; }
const loaderStart = performance.now();
function loaderTick(now){
  const t = Math.min((now - loaderStart) / FILL_MS, 1);
  const progress = Math.round(easeInOutCubic(t) * 100);
  loaderFill.style.width = progress + '%';
  loaderCount.textContent = String(progress).padStart(3, '0');
  if(t < 1){
    requestAnimationFrame(loaderTick);
  } else {
    loader.classList.add('exit');
    setTimeout(()=>{
      introReady = true;
      startScroll();
      loader.remove();
      heroReadyCallbacks.forEach(fn=>fn());
    }, 700);
  }
}
if(loader){ stopScroll(); requestAnimationFrame(loaderTick); }
else { setTimeout(()=>{ introReady = true; heroReadyCallbacks.forEach(fn=>fn()); }, 50); }
heroReadyCallbacks.push(()=>{ if(location.hash && document.getElementById(location.hash.slice(1))) setTimeout(()=> scrollToId(location.hash.slice(1)), 100); });

/* ================= REVEALS ================= */
// hero-gated reveals: fire on ready + fixed delay
document.querySelectorAll('[data-hero-delay]').forEach(el=>{
  const delay = parseInt(el.getAttribute('data-hero-delay'), 10) || 0;
  heroReadyCallbacks.push(()=> setTimeout(()=> el.classList.add('in-view'), delay));
});

// scroll-triggered reveals (everything with class reveal that isn't hero-gated)
const io = new IntersectionObserver((entries)=>{
  entries.forEach(entry=>{
    if(entry.isIntersecting){
      const el = entry.target;
      const delay = parseInt(el.getAttribute('data-delay'), 10) || 0;
      setTimeout(()=> el.classList.add('in-view'), delay);
      io.unobserve(el);
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal:not([data-hero-delay])').forEach(el=> io.observe(el));

/* ================= LIQUID REVEAL ================= */
(function liquidReveal(){
  const wrap = document.getElementById('liquid-wrap');
  if(!wrap) return;
  const canvas = document.getElementById('liquid-canvas');
  const ctx = canvas.getContext('2d');
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(reduced) return;

  const AFTER_SRC = wrap.dataset.after;
  const brushRadius = 143;
  const decay = 0.016;
  const dpr = Math.min(window.devicePixelRatio || 1, 2);

  let cw = 0, ch = 0, radius = brushRadius * dpr;
  let coverCanvas = document.createElement('canvas');
  let coverCtx = coverCanvas.getContext('2d');
  let brushCanvas = document.createElement('canvas');
  let brushCtx = brushCanvas.getContext('2d');
  let afterImg = new Image();
  let afterLoaded = false;
  afterImg.onload = ()=>{ afterLoaded = true; drawCover(); };
  afterImg.src = AFTER_SRC;

  function drawCover(){
    if(!afterLoaded || cw === 0 || ch === 0) return;
    coverCanvas.width = cw; coverCanvas.height = ch;
    const iw = afterImg.naturalWidth, ih = afterImg.naturalHeight;
    const scale = Math.min(cw / iw, ch / ih);
    const sw = iw * scale, sh = ih * scale;
    const sx = (cw - sw) / 2, sy = ch - sh;
    coverCtx.clearRect(0,0,cw,ch);
    coverCtx.drawImage(afterImg, sx, sy, sw, sh);
  }

  function resize(){
    const rect = wrap.getBoundingClientRect();
    cw = Math.max(1, Math.round(rect.width * dpr));
    ch = Math.max(1, Math.round(rect.height * dpr));
    canvas.width = cw; canvas.height = ch;
    canvas.style.width = rect.width + 'px';
    canvas.style.height = rect.height + 'px';
    drawCover();
  }
  const ro = new ResizeObserver(resize);
  ro.observe(wrap);
  resize();

  const diam = Math.ceil(radius * 2);
  brushCanvas.width = diam; brushCanvas.height = diam;

  let points = [];
  let last = null;
  let idle = 0;

  function toCanvasSpace(clientX, clientY){
    const rect = wrap.getBoundingClientRect();
    return { x: (clientX - rect.left) * dpr, y: (clientY - rect.top) * dpr };
  }

  window.addEventListener('pointermove', (e)=>{
    const p = toCanvasSpace(e.clientX, e.clientY);
    const outside = p.x < -radius || p.y < -radius || p.x > cw + radius || p.y > ch + radius;
    if(outside){ last = null; return; }
    if(last){
      const dx = p.x - last.x, dy = p.y - last.y;
      const dist = Math.hypot(dx, dy);
      const step = Math.max(radius * 0.3, 1);
      const n = Math.min(Math.ceil(dist / step), 60);
      for(let i=1;i<=n;i++){
        points.push({ x: last.x + (dx*i)/n, y: last.y + (dy*i)/n });
      }
    } else {
      points.push(p);
    }
    last = p;
  }, { passive: true });

  function stamp(x, y){
    brushCtx.globalCompositeOperation = 'source-over';
    brushCtx.clearRect(0,0,diam,diam);
    const grad = brushCtx.createRadialGradient(diam/2,diam/2,0,diam/2,diam/2,diam/2);
    grad.addColorStop(0, 'rgba(255,255,255,1)');
    grad.addColorStop(0.55, 'rgba(255,255,255,0.82)');
    grad.addColorStop(1, 'rgba(255,255,255,0)');
    brushCtx.fillStyle = grad;
    brushCtx.fillRect(0,0,diam,diam);
    brushCtx.globalCompositeOperation = 'source-in';
    brushCtx.drawImage(coverCanvas, x - radius, y - radius, diam, diam, 0, 0, diam, diam);
    ctx.globalCompositeOperation = 'source-over';
    ctx.drawImage(brushCanvas, x - radius, y - radius);
  }

  function tick(){
    if(cw && ch){
      const drawing = points.length > 0;
      if(drawing) idle = 0; else idle++;
      if(idle <= 120){
        const fade = drawing ? decay : Math.min(decay + idle * 0.004, 0.5);
        ctx.globalCompositeOperation = 'destination-out';
        ctx.fillStyle = `rgba(0,0,0,${fade})`;
        ctx.fillRect(0,0,cw,ch);
        if(drawing){
          points.forEach(p => stamp(p.x, p.y));
          points = [];
        }
      } else if(idle === 121){
        ctx.clearRect(0,0,cw,ch);
        idle = 200;
      }
    }
    requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);
})();

/* ================= WORKS FILTER ================= */
(function worksFilter(){
  const buttons = [...document.querySelectorAll('.works-filter-btn')];
  const items = [...document.querySelectorAll('#works-grid > li:not(#works-empty)')];
  const emptyState = document.getElementById('works-empty');
  function setFilter(filter){
    buttons.forEach(b=> b.classList.toggle('active', b.getAttribute('data-filter') === filter));
    let visibleCount = 0;
    items.forEach(li=>{
      const match = filter === 'all' || li.getAttribute('data-category') === filter;
      li.hidden = !match;
      if(match) visibleCount++;
    });
    emptyState.hidden = visibleCount > 0;
  }
  buttons.forEach(btn=> btn.addEventListener('click', ()=> setFilter(btn.getAttribute('data-filter'))));
})();

/* ================= STATS COUNT-UP ================= */
(function statsCountUp(){
  const counters = [...document.querySelectorAll('.stat-count')];
  const done = new Set();
  let ticking = false;
  function compute(){
    ticking = false;
    const vh = window.innerHeight;
    counters.forEach(el=>{
      if(done.has(el)) return;
      const rect = el.closest('li').getBoundingClientRect();
      const startMetric = vh;
      const endMetric = vh/2 - rect.height/2;
      let progress = (startMetric - rect.top) / (startMetric - endMetric || 1);
      progress = Math.max(0, Math.min(1, progress));
      const target = parseInt(el.getAttribute('data-target'), 10);
      el.textContent = Math.round(progress * target);
      if(progress >= 1) done.add(el);
    });
  }
  function onScroll(){
    if(ticking) return;
    ticking = true;
    setTimeout(compute, 30);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  lenis.on('scroll', onScroll);
  compute();
})();

/* ================= NAV MENU ================= */
const navMenu = document.getElementById('nav-menu');
function openNavMenu(){
  navMenu.classList.add('open');
  stopScroll();
  document.addEventListener('keydown', onNavMenuKey);
}
function closeNavMenu(){
  navMenu.classList.remove('open');
  startScroll();
  document.removeEventListener('keydown', onNavMenuKey);
}
function onNavMenuKey(e){ if(e.key === 'Escape') closeNavMenu(); }
document.getElementById('open-nav-menu').addEventListener('click', openNavMenu);
document.getElementById('close-nav-menu').addEventListener('click', closeNavMenu);
document.getElementById('nm-start-project').addEventListener('click', ()=>{
  closeNavMenu();
  openModal();
});

/* ================= REQUEST MODAL ================= */
const modal = document.getElementById('request-modal');
const formState = document.getElementById('modal-form-state');
const successState = document.getElementById('modal-success-state');
const requestForm = document.getElementById('request-form');
const submitLabel = document.getElementById('submit-label');

function openModal(){
  modal.classList.add('open');
  stopScroll();
  document.addEventListener('keydown', onModalKey);
}
function closeModal(){
  modal.classList.remove('open');
  startScroll();
  document.removeEventListener('keydown', onModalKey);
  setTimeout(()=>{
    formState.hidden = false;
    successState.hidden = true;
    requestForm.reset();
    submitLabel.textContent = requestForm.dataset.send;
  }, 300);
}
function onModalKey(e){ if(e.key === 'Escape') closeModal(); }

document.querySelectorAll('[data-open-modal]').forEach(el=>{
  el.addEventListener('click', (e)=>{ e.preventDefault(); if(navMenu.classList.contains('open')) closeNavMenu(); openModal(); });
});
document.getElementById('modal-close').addEventListener('click', closeModal);
document.getElementById('modal-success-close').addEventListener('click', closeModal);
modal.addEventListener('click', (e)=>{ if(e.target === modal) closeModal(); });
document.getElementById('modal-panel').addEventListener('click', (e)=> e.stopPropagation());

requestForm.addEventListener('submit', async (e)=>{
  e.preventDefault();
  submitLabel.textContent = requestForm.dataset.sending;
  try {
    const res = await fetch(requestForm.dataset.action, {
      method: 'POST',
      headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
      body: new FormData(requestForm)
    });
    if(!res.ok) throw new Error('failed');
    formState.hidden = true;
    successState.hidden = false;
  } catch(err){
    submitLabel.textContent = requestForm.dataset.failed;
  }
});
