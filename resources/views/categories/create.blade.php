@extends('layouts.app')

@section('title', 'Create Category · Admin')
@section('page_title', 'Create Category')
@section('page_subtitle', 'Add a new job category')

@push('styles')
<style>
    .form-container {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 16px;
        padding: 2rem;
        max-width: 800px;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #222;
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fcfcfc;
        font-size: 0.95rem;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #111;
        background: #fff;
    }
    .btn-primary {
        background: #111;
        color: #fff;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        background: #2a2a2a;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <form id="createCategoryForm">
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" id="name" name="name" required placeholder="e.g., Software Engineering" />
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" placeholder="Brief description of this category"></textarea>
        </div>
        <div class="form-group">
            <label for="icon">Icon (optional)</label>
            <input type="text" id="icon" name="icon" placeholder="e.g., &lt;i class='fas fa-code'&gt;" />
        </div>
        <button type="submit" class="btn-primary">Create Category</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('createCategoryForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = {
        name: document.getElementById('name').value,
        description: document.getElementById('description').value,
        icon: document.getElementById('icon').value
    };

    try {
        const response = await fetch(`${API_URL}/categories`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(formData)
        });
        const data = await response.json();

        if (data.success) {
            alert('Category created successfully!');
            window.location.href = '/categories';
        } else {
            alert(data.message || 'Failed to create category');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to create category');
    }
});
</script>
@endpush
