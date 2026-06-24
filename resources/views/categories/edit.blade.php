@extends('layouts.app')

@section('title', 'Edit Category · Admin')
@section('page_title', 'Edit Category')
@section('page_subtitle', 'Update category details')

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
    .btn-danger {
        background: #dc3545;
        color: #fff;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-left: 1rem;
    }
</style>
@endpush

@section('content')
<div class="form-container" id="formContainer">
    <div class="empty-state">
        <div class="loading-spinner" style="margin: 0 auto; margin-bottom: 1rem;"></div>
        <p>Loading category...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
let categoryId = null;

document.addEventListener('DOMContentLoaded', async () => {
    const id = window.location.pathname.split('/').pop();
    if (!id) {
        window.location.href = '/categories';
        return;
    }
    categoryId = id;
    await loadCategory(id);
});

async function loadCategory(id) {
    try {
        const response = await fetch(`${API_URL}/categories/${id}`, {
            headers: {
                'Content-Type': 'application/json'
            }
        });
        const data = await response.json();
        if (data.success && data.data) {
            renderForm(data.data);
        } else {
            showError('Category not found');
        }
    } catch (err) {
        console.error(err);
        showError('Failed to load category');
    }
}

function renderForm(category) {
    const container = document.getElementById('formContainer');
    container.innerHTML = `
        <form id="editCategoryForm">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" required value="${category.name || ''}" />
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4">${category.description || ''}</textarea>
            </div>
            <div class="form-group">
                <label for="icon">Icon (optional)</label>
                <input type="text" id="icon" name="icon" value="${category.icon || ''}" />
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn-primary">Update Category</button>
                <button type="button" class="btn-danger" onclick="deleteCategory()">Delete</button>
            </div>
        </form>
    `;

    document.getElementById('editCategoryForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        await updateCategory();
    });
}

async function updateCategory() {
    const formData = {
        name: document.getElementById('name').value,
        description: document.getElementById('description').value,
        icon: document.getElementById('icon').value
    };

    try {
        const response = await fetch(`${API_URL}/categories/${categoryId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(formData)
        });
        const data = await response.json();

        if (data.success) {
            alert('Category updated successfully!');
            window.location.href = '/categories';
        } else {
            alert(data.message || 'Failed to update category');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to update category');
    }
}

async function deleteCategory() {
    if (!confirm('Are you sure you want to delete this category?')) return;
    
    try {
        const response = await fetch(`${API_URL}/categories/${categoryId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        const data = await response.json();

        if (data.success) {
            alert('Category deleted successfully!');
            window.location.href = '/categories';
        } else {
            alert(data.message || 'Failed to delete category');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to delete category');
    }
}

function showError(message) {
    const container = document.getElementById('formContainer');
    container.innerHTML = `
        <div class="empty-state">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>Error</h3>
            <p>${message}</p>
            <a href="/categories" style="margin-top:1rem; display: inline-block;">Back to categories</a>
        </div>
    `;
}
</script>
@endpush
