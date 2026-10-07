<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    private function def(string $resource): array
    {
        return config("admin.{$resource}") ?? abort(404);
    }

    public function index(string $resource)
    {
        $def = $this->def($resource);

        // A single-record resource (Profile) opens straight in its edit form.
        if ($def['single'] ?? false) {
            $item = $def['model']::first() ?? $def['model']::create([]);

            return redirect()->route('admin.edit', [$resource, $item->id]);
        }

        [$col, $dir] = $def['order'];
        $rows = $def['model']::orderBy($col, $dir)->paginate(20);

        return view('admin.index', compact('resource', 'def', 'rows'));
    }

    public function create(string $resource)
    {
        $def = $this->def($resource);
        abort_if($def['readonly'] ?? false, 404);

        return view('admin.form', ['resource' => $resource, 'def' => $def, 'item' => new ($def['model'])]);
    }

    public function store(Request $request, string $resource)
    {
        $def = $this->def($resource);
        abort_if($def['readonly'] ?? false, 404);

        $item = new ($def['model']);
        $this->save($request, $def, $item);

        return redirect()->route('admin.index', $resource)->with('status', 'Saved.');
    }

    public function edit(string $resource, int $id)
    {
        $def = $this->def($resource);
        abort_if($def['readonly'] ?? false, 404);

        return view('admin.form', ['resource' => $resource, 'def' => $def, 'item' => $def['model']::findOrFail($id)]);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $def = $this->def($resource);
        abort_if($def['readonly'] ?? false, 404);

        $this->save($request, $def, $def['model']::findOrFail($id));

        return redirect()->route('admin.index', $resource)->with('status', 'Updated.');
    }

    public function destroy(string $resource, int $id)
    {
        $def = $this->def($resource);
        abort_if($def['single'] ?? false, 404);
        $def['model']::findOrFail($id)->delete();

        return back()->with('status', 'Deleted.');
    }

    private function save(Request $request, array $def, Model $item): void
    {
        $rules = [];
        foreach ($def['fields'] as $field) {
            if ($field[1] === 'image') {
                $rules[$field[0]] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:6144';
            } elseif ($field[1] !== 'checkbox') {
                $rules[$field[0]] = $field['rules'] ?? 'nullable';
            }
        }

        $request->validate($rules);
        $data = [];

        foreach ($def['fields'] as $field) {
            [$name, $type] = $field;

            $data[$name] = match ($type) {
                'checkbox' => $request->boolean($name),
                'tags' => array_values(array_filter(array_map('trim', explode(',', (string) $request->input($name))))),
                'image' => $request->hasFile($name) ? Images::storeWebp($request->file($name)) : $item->{$name},
                'number' => $request->filled($name) ? (int) $request->input($name) : null,
                default => $request->filled($name) ? $request->input($name) : null,
            };
        }

        if (array_key_exists('slug', $data)) {
            $data['slug'] = $this->uniqueSlug($def['model'], $data['slug'] ?: ($data['title'] ?? $data['title_id'] ?? ''), $item);
        }

        if (array_key_exists('published_at', $data) && ($data['is_published'] ?? false) && ! $data['published_at']) {
            $data['published_at'] = now();
        }

        if (array_key_exists('sort', $data) && $data['sort'] === null) {
            $data['sort'] = 0;
        }

        $item->fill($data)->save();
    }

    private function uniqueSlug(string $model, string $base, Model $current): string
    {
        $slug = Str::slug($base) ?: 'item';
        $candidate = $slug;
        $i = 2;

        while ($model::where('slug', $candidate)->where('id', '!=', $current->id ?? 0)->exists()) {
            $candidate = $slug.'-'.$i++;
        }

        return $candidate;
    }
}
