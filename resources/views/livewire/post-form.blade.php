@extends('layout.app')


@section('content')
    <div class="card shadow-sm p-4">
        <h4 class="mb-3">Create New Post</h4>

       
        <form wire:submit.prevent="submit">
            {{ $this->form }}

            
                <button type="submit" class="btn btn-primary">
                    Submit Post
                </button>
           
        </form>
    </div>
@endsection
