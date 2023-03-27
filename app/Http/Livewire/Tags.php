<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class Tags extends Component
{
    public Post $post;
    public $tags;

    protected $listeners = ['addTag', 'removeTag'];

    public function mount(): void
    {
        $this->post->load('tags');
        $this->tags = json_encode($this->post->tags->pluck('title'));
    }

    public function render()
    {
        return view('livewire.tags');
    }

    public function addTag($tag)
    {
        $this->post->attachTag($tag);
        $this->emit('tagAddedOnBackend', $tag);
    }

    public function removeTag($tag)
    {
        $this->post->detachTag($tag);
        $this->emit('tagRemovedOnBackend', $tag);
    }
}
