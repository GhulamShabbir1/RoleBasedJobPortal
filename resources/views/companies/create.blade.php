@extends('layouts.app')

@section('title', 'Register Company · Job Board')
@section('page_title', 'Register Company')
@section('page_subtitle', '· get approved to post jobs')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3 style="margin-bottom: 1.5rem; color: #111;">Company Details</h3>
    
    <div id="alertBox" style="display:none; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem;"></div>

    <form id="createCompanyForm" onsubmit="submitCompany(event)">
        <div class="form-group">
            <label for="name">Company Name *</label>
            <input type="text" id="name" class="form-control" required />
        </div>
        
        <div class="form-group">
            <label for="email">Company Email *</label>
            <input type="email" id="email" class="form-control" required />
        </div>

        <div class="form-group">
            <label for="description">Description *</label>
            <textarea id="description" class="form-control" placeholder="What does your company do?" required></textarea>
        </div>

        <div class="form-group">
            <label for="industry">Industry *</label>
            <input type="text" id="industry" class="form-control" placeholder="e.g. Technology" required />
        </div>

        <div class="form-group">
            <label for="website">Website (Optional)</label>
            <input type="url" id="website" class="form-control" placeholder="https://..." />
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="phone">Phone *</label>
                <input type="text" id="phone" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="city">City *</label>
                <input type="text" id="city" class="form-control" required />
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="state">State *</label>
                <input type="text" id="state" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="country">Country *</label>
                <input type="text" id="country" class="form-control" required />
            </div>
        </div>

        <div class="form-group">
            <label for="address">Full Address *</label>
            <input type="text" id="address" class="form-control" required />
        </div>

        <hr style="border:none; border-top: 1px solid #eee; margin: 2rem 0;">
        <h3 style="margin-bottom: 1.5rem; color: #111;">Verification Documents</h3>

        <div class="form-group">
            <label for="logo">Company Logo * (Image)</label>
            <input type="file" id="logo" class="form-control" accept="image/*" required style="padding: 0.5rem;" />
        </div>

        <div class="form-group">
            <label for="certificate">Registration Certificate * (PDF/Image)</label>
            <input type="file" id="certificate" class="form-control" accept="image/*,.pdf" required style="padding: 0.5rem;" />
            <small class="text-muted" style="display:block; margin-top:0.4rem;">Used by Admins to verify your company's legitimacy.</small>
        </div>

        <div class="form-group" style="margin-top: 2rem;">
            <button type="submit" class="btn" id="submitBtn" style="width: 100%;">
                Submit for Verification <i class="fas fa-arrow-right" style="margin-left:0.5rem;"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Ensure only Employers can view this
    if (currentUser.role !== 'employer') {
        alert('Only employers can register companies.');
        window.location.href = '/dashboard';
    }

    async function submitCompany(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        const alertBox = document.getElementById('alertBox');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting... <i class="fas fa-spinner fa-spin"></i>';
        
        // Prepare FormData for file uploads
        const formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('industry', document.getElementById('industry').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('city', document.getElementById('city').value);
        formData.append('state', document.getElementById('state').value);
        formData.append('country', document.getElementById('country').value);
        formData.append('address', document.getElementById('address').value);
        
        const website = document.getElementById('website').value;
        if(website) formData.append('website', website);

        const logoFile = document.getElementById('logo').files[0];
        const certFile = document.getElementById('certificate').files[0];
        
        if (logoFile) formData.append('logo', logoFile);
        if (certFile) formData.append('certificate', certFile);

        try {
            const response = await fetch(`${API_URL}/companies`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                    // Do NOT set Content-Type for FormData, let the browser set the boundary!
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alertBox.style.display = 'block';
                alertBox.style.backgroundColor = '#d4edda';
                alertBox.style.color = '#155724';
                alertBox.innerText = 'Company registered successfully. It is now pending Admin approval.';
                document.getElementById('createCompanyForm').reset();
                
                setTimeout(() => window.location.href = '/dashboard', 2000);
            } else {
                alertBox.style.display = 'block';
                alertBox.style.backgroundColor = '#f8d7da';
                alertBox.style.color = '#721c24';
                alertBox.innerText = 'Error: ' + (data.message || 'Validation failed');
            }
        } catch (err) {
            console.error(err);
            alertBox.style.display = 'block';
            alertBox.style.backgroundColor = '#f8d7da';
            alertBox.style.color = '#721c24';
            alertBox.innerText = 'A network error occurred.';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit for Verification <i class="fas fa-arrow-right" style="margin-left:0.5rem;"></i>';
        }
    }
</script>
@endpush
