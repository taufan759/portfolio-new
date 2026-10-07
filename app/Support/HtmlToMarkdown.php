<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Small HTML to Markdown converter for article bodies (built for Medium's RSS markup:
 * paragraphs, headings, emphasis, links, lists, quotes, code and figures).
 */
class HtmlToMarkdown
{
    /** @var callable|null  fn(string $src): ?string  maps an image URL to the URL to write into the Markdown */
    private $imageResolver;

    public function __construct(?callable $imageResolver = null)
    {
        $this->imageResolver = $imageResolver;
    }

    public function convert(string $html): string
    {
        // Medium uses non-breaking and hair spaces; treat them as ordinary spaces.
        $html = preg_replace('/[\x{00A0}\x{2000}-\x{200B}\x{202F}\x{205F}\x{3000}]/u', ' ', $html) ?? $html;

        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8"><body>'.$html.'</body>', LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $body = $dom->getElementsByTagName('body')->item(0);
        $md = $this->children($body);

        // Tidy blank lines.
        $md = preg_replace("/[ \t]+\n/", "\n", $md);
        $md = preg_replace("/\n{3,}/", "\n\n", $md);

        return trim($md)."\n";
    }

    private function children(DOMNode $node): string
    {
        $out = '';
        foreach ($node->childNodes as $child) {
            $out .= $this->node($child);
        }

        return $out;
    }

    private function inline(DOMNode $node): string
    {
        return trim(preg_replace('/\s+/', ' ', $this->children($node)));
    }

    private function node(DOMNode $n): string
    {
        if ($n->nodeType === XML_TEXT_NODE) {
            return preg_replace('/\s+/', ' ', $n->textContent);
        }

        if (! $n instanceof DOMElement) {
            return '';
        }

        $tag = strtolower($n->tagName);

        return match ($tag) {
            'p' => ($t = $this->inline($n)) === '' ? '' : $t."\n\n",
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6' => $this->heading($n, $tag),
            'strong', 'b' => $this->wrap($n, '**'),
            'em', 'i' => $this->wrap($n, '*'),
            'a' => $this->link($n),
            'br' => "  \n",
            'hr' => "\n---\n\n",
            'ul', 'ol' => $this->listOf($n, $tag === 'ol')."\n",
            'blockquote' => $this->quote($n),
            'pre' => "```\n".trim($n->textContent)."\n```\n\n",
            'code' => '`'.trim($n->textContent).'`',
            'figure' => $this->figure($n),
            'img' => $this->image($n),
            'script', 'style', 'iframe' => '',
            default => $this->children($n),
        };
    }

    /** Emphasis markers must hug the text, so any surrounding spaces are moved outside them. */
    private function wrap(DOMElement $n, string $marker): string
    {
        $raw = preg_replace('/\s+/', ' ', $this->children($n));
        $text = trim($raw);

        if ($text === '') {
            return $raw === '' ? '' : ' ';
        }

        return (str_starts_with($raw, ' ') ? ' ' : '').$marker.$text.$marker.(str_ends_with($raw, ' ') ? ' ' : '');
    }

    private function heading(DOMElement $n, string $tag): string
    {
        $text = $this->inline($n);
        if ($text === '') {
            return '';
        }

        // The page title is the article title, so section headings start at level 2.
        $level = min(max((int) substr($tag, 1), 1) + 1, 4);

        return str_repeat('#', $level).' '.$text."\n\n";
    }

    private function link(DOMElement $n): string
    {
        $text = $this->inline($n);
        $href = trim($n->getAttribute('href'));

        if ($text === '' || $href === '') {
            return $text;
        }

        return '['.$text.']('.$href.')';
    }

    private function listOf(DOMElement $list, bool $ordered): string
    {
        $out = '';
        $i = 1;
        foreach ($list->childNodes as $li) {
            if ($li instanceof DOMElement && strtolower($li->tagName) === 'li') {
                $out .= ($ordered ? $i++.'. ' : '- ').$this->inline($li)."\n";
            }
        }

        return $out;
    }

    private function quote(DOMElement $n): string
    {
        $text = trim($this->children($n));
        if ($text === '') {
            return '';
        }

        return preg_replace('/^/m', '> ', $text)."\n\n";
    }

    private function figure(DOMElement $n): string
    {
        $out = '';
        $caption = '';
        foreach ($n->childNodes as $c) {
            if (! $c instanceof DOMElement) {
                continue;
            }
            if (strtolower($c->tagName) === 'figcaption') {
                $caption = $this->inline($c);
            } else {
                $out .= $this->node($c);
            }
        }

        $out = trim($out);

        return $out === '' ? '' : $out.($caption !== '' ? "\n*{$caption}*" : '')."\n\n";
    }

    private function image(DOMElement $n): string
    {
        $src = $n->getAttribute('src');
        // Medium adds a 1x1 tracking pixel at the end of every feed item.
        if ($src === '' || str_contains($src, '/_/stat')) {
            return '';
        }

        if ($this->imageResolver) {
            $src = ($this->imageResolver)($src);
            if ($src === null) {
                return '';
            }
        }

        $alt = trim(str_replace(['[', ']'], '', $n->getAttribute('alt')));

        return "![{$alt}]({$src})";
    }
}
