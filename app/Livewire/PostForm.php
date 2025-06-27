<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component implements HasForms
{
    use InteractsWithForms, WithFileUploads;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Select::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->required(),
            FileUpload::make('thumbnail')
                ->image()
                ->directory('posts/thumbnails')
                ->imagePreviewHeight('200')
                ->maxSize(2048),
            MarkdownEditor::make('content')
                ->fileAttachmentsDirectory('posts/content-images')
                ->required()
                ->label('Post Body'),
            TextInput::make('guest_name')
                ->label('Your name')
                ->required(),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $data['is_guest'] = true;
        $data['status'] = 0;

        Post::create($data);

        session()->flash('success', 'Post created successfully!');

        // Redirect to the same route to show form again
        $this->redirect(request()->header('Referer') ?? route('posts.create'), navigate: true);
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
