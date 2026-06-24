@extends('layouts.app')

@section('title', 'Manage Categories · jobboard')
@section('page_title', 'Manage Categories')

@section('content')
<div class="bg-white border border-gray-200 rounded-2xl p-8 mb-6">
    <form id="createCategoryForm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label for="name" class="block text-sm font-semibold mb-1">Name</label>
                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-xl">
            </div>
            <div>
                <label for="icon" class="block text-sm font-semibold mb-1">Icon (optional)</label>
                <input type="text" id="icon" name="icon" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-black text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-800">
                    Create Category
                </button>
            </div>
        </div>
        <div>
            <label for="description" class="block text-sm font-semibold mb-1">Description (optional)</label>
            <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl"></textarea>
        </div>
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase">ID</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase">Name</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase">Description</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase">Icon</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-600 uppercase text-right">Actions</th>
            </tr>
        </thead>
        <tbody id="categoriesTableBody" class="divide-y divide-gray-100">
            <tr>
                <td class="px-6 py-4" colspan="5">Loading categories...</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
async function loadCategories() {
    try {
        const response = await fetch(`${API_URL}/categories`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await response.json();
        if (data.success) {
            renderCategories(data.data);
        }
    } catch (error) {
        console.error(error);
    }
}

function renderCategories(categories) {
    const tbody = document.getElementById('categoriesTableBody');
    tbody.innerHTML = categories.map(category => `
        <tr class="hover:bg-gray-50 group">
            <td class="px-6 py-4">${category.id}</td>
            <td class="px-6 py-4 font-semibold">${category.name}</td>
            <td class="px-6 py-4 text-gray-600">${category.description || '-'}</td>
            <td class="px-6 py-4">${category.icon || '-'}</td>
            <td class="px-6 py-4 text-right">
                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button class="text-blue-600 hover:text-blue-700 font-semibold" type="button" onclick="editCategory(${category.id}, '${category.name}', '${category.description || ''}', '${category.icon || ''}')">
                        Edit
                    </button>
                    <button class="text-red-600 hover:text-red-700 font-semibold" type="button" onclick="deleteCategory(${category.id})">
                        Delete
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function editCategory(id, name, description, icon) {
    const newName = prompt('Category Name:', name);
    if (newName !== null) {
        const newDescription = prompt('Category Description:', description);
        const newIcon = prompt('Category Icon:', icon);
        updateCategory(id, newName, newDescription, newIcon);
    }
}

async function updateCategory(id, name, description, icon) {
    try {
        const response = await fetch(`${API_URL}/categories/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name, description, icon })
        });
        const data = await response.json();
        if (data.success) {
            loadCategories();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error(error);
    }
}

async function deleteCategory(id) {
    if (!confirm('Are you sure you want to delete this category?')) return;
    try {
        const response = await fetch(`${API_URL}/categories/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if (data.success) {
            loadCategories();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error(error);
    }
}

document.getElementById('createCategoryForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const response = await fetch(`${API_URL}/categories`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                icon: document.getElementById('icon').value
            })
        });
        const data = await response.json();
        if (data.success) {
            document.getElementById('createCategoryForm').reset();
            loadCategories();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error(error);
    }
});

document.addEventListener('DOMContentLoaded', loadCategories);
</script>
@endpush
