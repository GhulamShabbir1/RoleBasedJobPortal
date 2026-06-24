@extends('layouts.app')

@section('title', 'Create Candidate Profile')
@section('page_title', 'Create Candidate Profile')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm p-8">
    <form id="create-profile-form">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold mb-2" for="phone">Phone</label>
                <input id="phone" name="phone" type="tel"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2" for="city">City</label>
                <input id="city" name="city" type="text"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2" for="skills">Skills (comma separated)</label>
            <input id="skills" name="skills" type="text" placeholder="e.g., PHP, Laravel, MySQL"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2" for="experience">Experience</label>
            <textarea id="experience" name="experience" rows="4"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2" for="bio">Bio</label>
            <textarea id="bio" name="bio" rows="3"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold mb-2" for="education">Education</label>
                <input id="education" name="education" type="text"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2" for="portfolio_url">Portfolio URL</label>
                <input id="portfolio_url" name="portfolio_url" type="url"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-semibold mb-2" for="resume_url">Resume URL</label>
            <input id="resume_url" name="resume_url" type="url"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-8 py-3 bg-black text-white font-semibold rounded-full hover:bg-gray-800 transition-colors">
                Create Profile
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('create-profile-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const token = localStorage.getItem('token');
        const formData = {
            phone: document.getElementById('phone').value,
            city: document.getElementById('city').value,
            skills: document.getElementById('skills').value,
            experience: document.getElementById('experience').value,
            bio: document.getElementById('bio').value,
            education: document.getElementById('education').value,
            portfolio_url: document.getElementById('portfolio_url').value,
            resume_url: document.getElementById('resume_url').value
        };
        const res = await fetch(`${API_URL}/candidate-profiles`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                Authorization: `Bearer ${token}`
            },
            body: JSON.stringify(formData)
        });
        const json = await res.json();
        if (json.success) {
            window.location.href = '/dashboard/candidate';
        } else {
            alert(json.message || 'Failed to create profile');
        }
    } catch (err) {
        console.error(err);
        alert('Failed to create profile');
    }
});
</script>
@endpush
