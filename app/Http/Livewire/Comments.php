<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Comments extends Component
{
    public Post $post;
    public string $author = '';
    public string $text = '';

    protected array $rules = [
        'author' => 'required|string|min:4',
        'text' => 'required|string|min:5',
    ];

    /**
     * @throws ValidationException
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetSuccessMessage(): void
    {
        session()->forget('success_message');
    }

    public function render(): View
    {
        return view('livewire.comments', [
            'comments' => $this->post->comments->sortDesc()
        ]);
    }

    public function add(): void
    {
        $formData = $this->validate();

        sleep(1);

        $this->post->comments()->create($formData);

        session()->flash('success_message', __('Your comment has been sent!'));

        $this->reset('author', 'text');

        $this->post = Post::query()->find($this->post->id)->getModel();
    }
}
