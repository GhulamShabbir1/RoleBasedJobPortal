@extends('layouts.app')

@section('title', 'Categories · Job Board')
@section('page_title', 'Job Categories')
@section('page_subtitle', 'Browse jobs by category')

@push('styles')
<style>
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .category-card {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: all 0.25s;
        cursor: pointer;
    }
    .category-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: #ccc;
    }
    .category-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f5f5f5, #eaeaea);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }
    .category-card h3 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 0.5rem;
    }
    .category-card p {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }
    .category-count {
        font-weight: 600;
        color: #111;
        font-size: 0.95rem;
    }
</style>
@endpush

@section('content')
<div class="categories-grid" id="categoriesGrid">
    <div class="empty-state" style="grid-column: 1 / -1;">
        <div class="loading-spinner" style="margin: 0 auto; margin-bottom: 1rem;"></div>
        <p>Loading categories...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch(`${API_URL}/categories`, {
            headers: {
                'Content-Type': 'application/json'
            }
        });
        const data = await response.json();
        if (data.success && data.data) {
            renderCategories(data.data);
        } else {
            showEmpty('No categories available');
        }
    } catch (err) {
        console.error(err);
        showEmpty('Failed to load categories');
    }
});

function renderCategories(categories) {
    const container = document.getElementById('categoriesGrid');
    if (!categories.length) {
        showEmpty();
        return;
    }
    container.innerHTML = categories.map(category => `
        <div class="category-card" onclick="window.location.href='/jobs?category=${category.id}'">
            <div class="category-icon">
                ${category.icon ? category.icon : '<i class="fas fa-folder"></i>'}
            </div>
            <h3>${category.name}</h3>
            <p>${category.description || ''}</p>
            <div class="category-count">
                ${category.job_count || 0} jobs
            </div>
        </div>
    `).join('');
}

function showEmpty(message = 'No categories found.') {
    const container = document.getElementById('categoriesGrid');
    container.innerHTML = `
        <div class="empty-state" style="grid-column:1/-1;">
            <i class="fas fa-folder-open"></i>
            <h3>No Categories</h3>
            <p>${message}</p>
        </div>
    `;
}
</script>
@endpush
