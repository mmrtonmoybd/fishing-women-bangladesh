@extends('layout.app')

@section('meta')
<!-- TUI Editor CSS -->
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css">
    <style>
        .tui-editor-defaultUI {
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
@endsection
@section('content')
<div class="container py-4">
    <h4>পোস্ট করুণ</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>শিরোনাম</label>
            <input name="title" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label>শ্রেণি</label>
            <select name="category_id" class="form-control">
                <option value="">Select Category</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        @if(!auth()->check())
        <div class="form-group">
            <label>আপনার নাম</label>
            <input name="guest_name" required class="form-control" value="{{ old('guest_name') }}">
        </div>
        @endif

        <div class="form-group">
            <label>পোস্ট কন্টেন্ট</label>
            <!-- Editor will render here -->
            <div id="editor-root"></div>
            <textarea name="content" id="markdown-editor" class="form-control" style="display:none;">{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label>ইউটিউব ভিডিও লিংক(বাধ্যতামূলক না) (<font color='red'>ইউটিউব ভিডিও দেওয়া হলে সেক্ষেত্রে ছবি / ভিডিও / অডিও প্রদান বাধ্যতামূলক না।</font>)</label>
            <input name="youtube_url" class="form-control" value="{{ old('youtube_url') }}">
        </div>

        <div class="form-group">
            <label>ছবি / ভিডিও / অডিও</label>
            <input type="file" name="thumbnail" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">জমা দিন</button>
    </form>
</div>

<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script>
    const textarea = document.getElementById('markdown-editor');
    const editorRoot = document.getElementById('editor-root');

    const editor = new toastui.Editor({
        el: editorRoot,
        height: '500px',
        initialEditType: 'markdown',
        previewStyle: 'tab',
        initialValue: textarea.value,
        hooks: {
            addImageBlobHook: (blob, callback) => {
                const formData = new FormData();
                formData.append('file', blob);

                fetch('/upload-file', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.url) {
                        const ext = blob.name?.split('.').pop()?.toLowerCase() || '';
                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                            callback(data.url, blob.name);
                        } else {
                            const fileLink = `[Download ${blob.name || 'file'}](${data.url})`;
                            editor.insertText(fileLink);
                        }
                    } else {
                        alert(data.error || "Upload failed");
                    }
                })
                .catch(() => alert("Upload failed"));
            }
        }
    });

    // Sync content before submit
    document.querySelector('form').addEventListener('submit', function () {
        textarea.value = editor.getMarkdown();
    });
</script>


@endsection


