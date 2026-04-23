@extends('layouts.app')

@section('title', 'Add New Domain')
@section('description', 'Add a new domain to your management system')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Domain</h5>
                <p class="card-subtitle">Register or add an existing domain to your management system</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('domains.store') }}">
                    @csrf
                    
                    <!-- Domain Information -->
                    <div class="mb-4">
                        <h6 class="mb-3">Domain Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="domain" class="form-label">Domain Name *</label>
                                <input type="text" class="form-control" id="domain" name="domain" required 
                                       placeholder="example.com">
                                <small class="text-muted">Enter the domain name without www or subdomains</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="domain_type" class="form-label">Domain Type *</label>
                                <select class="form-select" id="domain_type" name="domain_type" required>
                                    <option value="">Select Domain Type</option>
                                    <option value="new">Register New Domain</option>
                                    <option value="existing">Add Existing Domain</option>
                                    <option value="transfer">Transfer Domain</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="registrar" class="form-label">Registrar *</label>
                                <select class="form-select" id="registrar" name="registrar" required>
                                    <option value="">Select Registrar</option>
                                    <option value="godaddy">GoDaddy</option>
                                    <option value="namecheap">Namecheap</option>
                                    <option value="cloudflare">Cloudflare</option>
                                    <option value="google">Google Domains</option>
                                    <option value="porkbun">Porkbun</option>
                                    <option value="name">Name.com</option>
                                    <option value="hover">Hover</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date *</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2" 
                                          placeholder="Brief description of the domain purpose"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Nameservers -->
                    <div class="mb-4">
                        <h6 class="mb-3">Nameservers</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nameserver_type" class="form-label">Nameserver Type</label>
                                <select class="form-select" id="nameserver_type" name="nameserver_type">
                                    <option value="custom">Custom Nameservers</option>
                                    <option value="default">Default Registrar Nameservers</option>
                                    <option value="cloudflare">Cloudflare Nameservers</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nameserver1" class="form-label">Nameserver 1 *</label>
                                <input type="text" class="form-control" id="nameserver1" name="nameserver1" 
                                       placeholder="ns1.example.com" value="ns1.example.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nameserver2" class="form-label">Nameserver 2 *</label>
                                <input type="text" class="form-control" id="nameserver2" name="nameserver2" 
                                       placeholder="ns2.example.com" value="ns2.example.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nameserver3" class="form-label">Nameserver 3 (Optional)</label>
                                <input type="text" class="form-control" id="nameserver3" name="nameserver3" 
                                       placeholder="ns3.example.com">
                            </div>
                        </div>
                    </div>

                    <!-- SSL Configuration -->
                    <div class="mb-4">
                        <h6 class="mb-3">SSL Configuration</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="auto_ssl" name="auto_ssl" checked>
                                    <label class="form-check-label" for="auto_ssl">
                                        Enable Auto SSL (Let's Encrypt)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="wildcard_ssl" name="wildcard_ssl">
                                    <label class="form-check-label" for="wildcard_ssl">
                                        Request Wildcard Certificate
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="force_https" name="force_https" checked>
                                    <label class="form-check-label" for="force_https">
                                        Force HTTPS Redirect
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DNS Records -->
                    <div class="mb-4">
                        <h6 class="mb-3">Initial DNS Records</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_a_record" name="create_a_record" checked>
                                    <label class="form-check-label" for="create_a_record">
                                        Create A Record (point to server IP)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_www_record" name="create_www_record" checked>
                                    <label class="form-check-label" for="create_www_record">
                                        Create WWW Record
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_mx_record" name="create_mx_record">
                                    <label class="form-check-label" for="create_mx_record">
                                        Create MX Record (Mail Server)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_spf_record" name="create_spf_record" checked>
                                    <label class="form-check-label" for="create_spf_record">
                                        Create SPF Record
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_dmarc_record" name="create_dmarc_record" checked>
                                    <label class="form-check-label" for="create_dmarc_record">
                                        Create DMARC Record
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Domain Features -->
                    <div class="mb-4">
                        <h6 class="mb-3">Domain Features</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="auto_renew" name="auto_renew" checked>
                                    <label class="form-check-label" for="auto_renew">
                                        Enable Auto Renewal
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="privacy_protection" name="privacy_protection" checked>
                                    <label class="form-check-label" for="privacy_protection">
                                        Enable Privacy Protection
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="transfer_lock" name="transfer_lock" checked>
                                    <label class="form-check-label" for="transfer_lock">
                                        Enable Transfer Lock
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="dnssec" name="dnssec">
                                    <label class="form-check-label" for="dnssec">
                                        Enable DNSSEC
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('domains.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-left me-1"></i> Cancel
                        </a>
                        <div>
                            <button type="button" class="btn btn-outline-primary me-2" onclick="checkAvailability()">
                                <i class="bx bx-search me-1"></i> Check Availability
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Add Domain
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function checkAvailability() {
    const button = event.target;
    const domainInput = document.getElementById('domain');
    const domain = domainInput.value;
    
    if (!domain) {
        showNotification('Please enter a domain name', 'warning');
        return;
    }
    
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Checking...';
    
    // Simulate availability check
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-search me-1"></i> Check Availability';
        
        // Simulate random availability
        const available = Math.random() > 0.5;
        if (available) {
            showNotification('Domain is available for registration!', 'success');
        } else {
            showNotification('Domain is already registered. You can still add it to management.', 'info');
        }
    }, 2000);
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}
</script>
@endpush
