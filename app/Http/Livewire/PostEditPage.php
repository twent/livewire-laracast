<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostEditPage extends Component
{
    use WithFileUploads;

    public Post $post;
    public $thumbnail = null;

    protected array $rules = [
        'post.title' => 'required|string|min:6',
        'post.slug' => 'required|string|min:5|max:255',
        'post.author' => 'required|string|min:5|max:128',
        'thumbnail' => 'nullable|sometimes|image|mimes:jpg,jpeg,png,svg|max:2000',
        'post.intro' => 'required|string|max:128',
        'post.content' => 'required|string|min:50',
        'post.published_at' => 'required|date',
    ];

    /**
     * @throws ValidationException
     */
    public function updatedThumbnail(): void
    {
        $this->validateOnly('thumbnail');
    }

    public function resetSuccessMessage(): void
    {
        session()->forget('success_message');
    }

    public function save()
    {
        $formData = $this->validate();

        if ($this->post->isClean() && ! $this->thumbnail) {
            session()->flash('success_message', __('Post already actual'));
            return;
        }

        if ($this->thumbnail) {
            $formData['thumbnail'] = $this->thumbnail->store('photos');
            $this->post->update($formData);
        } else {
            $this->post->save();
        }

        sleep(1);

        session()->flash('success_message', __('Post has been updated'));
    }

    public function render(): View
    {
        return view('livewire.post-edit-page');
    }
}
