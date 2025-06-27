<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.post.post-list', [
            'posts' => Post::where('status', true)->paginate(10),
            'title' => 'Home',
        ]);
    }
}
