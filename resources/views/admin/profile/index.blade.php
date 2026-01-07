@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="section-body">
    <div class="row mt-sm-4">
        <div class="col-6 col-md-6 col-lg-6">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="/admin/assets/img/pp.jpeg" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Posts</div>
                            <div class="profile-widget-item-value">187</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Followers</div>
                            <div class="profile-widget-item-value">6,8K</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Following</div>
                            <div class="profile-widget-item-value">2,1K</div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name">{{ $user->name }} <div
                            class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div> Admin
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>User Settings</h4>
                    <div class="card-header-action">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                                    aria-controls="home" aria-selected="true"><i class="fas fa-user"></i> Edit
                                    Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                    aria-controls="profile" aria-selected="false"><i class="fas fa-shield-alt"></i>
                                    Security</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent2">
                        <!-- Tab 1: Edit Profile -->
                        <div class="tab-pane fade show active" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                            <form method="post" action="{{ route('admin.profile.update') }}" class="needs-validation"
                                novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="row mt-4">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $user->name) }}" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the name
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $user->email) }}" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 2: Security -->
                        <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">

                            <!-- Change Password -->
                            <div class="section-title mt-0">Change Password</div>
                            <form method="post" action="{{ route('admin.profile.password') }}" class="needs-validation"
                                novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" class="form-control" name="current_password" required="">
                                    <div class="invalid-feedback">
                                        Please fill in your current password
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="password" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the new password
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            required="">
                                        <div class="invalid-feedback">
                                            Please confirm your new password
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mb-4">
                                    <button class="btn btn-primary">Change Password</button>
                                </div>
                            </form>

                            <div class="dropdown-divider"></div>

                            <!-- Two Factor Auth -->
                            <div class="card-header p-0 pb-3">
                                <h4 class="text-primary"><i class="fas fa-shield-alt"></i> Two-Factor Authentication
                                </h4>
                            </div>

                            <div id="two-factor-wrapper">
                                <div class="card-body p-0">
                                    <div id="two-factor-status-alert">
                                        @if (session('status') == 'two-factor-authentication-enabled' ||
                                        session('status') == 'two-factor-authentication-confirmed')
                                        <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                                            <div class="alert-icon"><i class="fas fa-check"></i></div>
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                                <div class="alert-title">Success</div>
                                                {{ session('status') == 'two-factor-authentication-confirmed' ?
                                                'Two-factor authentication has been enabled successfully!' : 'Please
                                                finish configuring two-factor authentication to secure your account.' }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div id="two-factor-content">
                                        @if (!auth()->user()->two_factor_secret)
                                        {{-- State: Not Enabled --}}
                                        <div class="empty-state p-0 text-left">
                                            <p class="text-muted">Two-factor authentication adds an additional layer of
                                                security to your account by requiring more than just a password to log
                                                in.</p>
                                            <button type="button" onclick="toggle2FA('enable')"
                                                class="btn btn-primary btn-icon icon-left" id="btn-enable-2fa">
                                                <i class="fas fa-plus"></i> Enable Two-Factor Authentication
                                            </button>
                                        </div>
                                        @else
                                        {{-- State: Enabled (Secret exists) --}}

                                        @if (!auth()->user()->two_factor_confirmed_at)
                                        {{-- State: Not Confirmed --}}
                                        <div class="section-title mt-0 text-center">Finish Configuration</div>
                                        <div class="text-center">
                                            <div class="p-3 bg-white border rounded shadow-sm d-inline-block mb-4">
                                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                            </div>

                                            <div class="mx-auto" style="max-width: 600px;">
                                                <p class="mb-4">Scan the QR code above with your authenticator app
                                                    (Google Authenticator, Authy, etc.) and enter the 6-digit code below
                                                    to confirm.</p>

                                                <div class="form-group mb-4">
                                                    <label class="font-weight-bold">Authentication Code</label>
                                                    <div class="input-group">
                                                        <input type="text" id="two_factor_code" class="form-control"
                                                            placeholder="000000" maxlength="6"
                                                            autocomplete="one-time-code"
                                                            style="letter-spacing: 5px; font-weight: bold; font-size: 1.2rem; text-align: center;">
                                                        <div class="input-group-append">
                                                            <button type="button" onclick="confirm2FA()"
                                                                class="btn btn-primary btn-lg px-4"
                                                                id="btn-confirm-2fa">Confirm Activation</button>
                                                        </div>
                                                    </div>
                                                    <small class="text-danger d-none mt-2" id="confirm-error"><i
                                                            class="fas fa-exclamation-triangle"></i> Invalid code.
                                                        Please try again.</small>
                                                </div>

                                                <div class="mt-2">
                                                    <button type="button" onclick="toggle2FA('disable')"
                                                        class="btn btn-outline-danger btn-sm" id="btn-cancel-2fa">
                                                        <i class="fas fa-times"></i> Cancel Setup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        {{-- State: Confirmed --}}
                                        <div class="alert alert-info alert-has-icon shadow-sm mb-4">
                                            <div class="alert-icon"><i class="fas fa-shield-check"></i></div>
                                            <div class="alert-body">
                                                <div class="alert-title">Active</div>
                                                Two-factor authentication is currently active on your account.
                                            </div>
                                        </div>

                                        <div class="text-center mb-4">
                                            <div class="p-3 bg-white border rounded shadow-sm d-inline-block mb-4">
                                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                            </div>

                                            <div class="text-left mx-auto" style="max-width: 600px;">
                                                <h6 class="font-weight-bold">Recovery Codes</h6>
                                                <p class="text-muted small">Store these recovery codes in a secure
                                                    password manager. They can be used to recover access to your account
                                                    if your device is lost.</p>

                                                <div class="bg-light p-3 border rounded mb-4"
                                                    style="column-count: 2; font-family: 'Courier New', Courier, monospace; font-size: 0.9rem; font-weight: bold; color: #333;">
                                                    @php
                                                    $recoveryCodes =
                                                    json_decode(decrypt(auth()->user()->two_factor_recovery_codes),
                                                    true);
                                                    @endphp
                                                    @foreach ($recoveryCodes as $code)
                                                    <div class="mb-1"><i class="fas fa-key mr-2 text-muted small"></i>{{
                                                        $code }}</div>
                                                    @endforeach
                                                </div>

                                                <div class="d-flex justify-content-center">
                                                    <button type="button" onclick="regenerateRecoveryCodes()"
                                                        class="btn btn-outline-secondary btn-icon icon-left mr-3"
                                                        id="btn-regen-codes">
                                                        <i class="fas fa-sync"></i> Regenerate Codes
                                                    </button>
                                                    <button type="button" onclick="toggle2FA('disable')"
                                                        class="btn btn-danger btn-icon icon-left" id="btn-disable-2fa">
                                                        <i class="fas fa-trash"></i> Disable 2FA
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-divider mt-4"></div>

                            <!-- Browser Sessions -->
                            <div class="section-title">Browser Sessions</div>
                            <p class="text-muted">Manage and log out your active sessions on other browsers and devices.
                            </p>

                            @if (count($sessions) > 0)
                            <div class="mb-4">
                                @foreach ($sessions as $session)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="mr-3">
                                        @if ($session->agent['is_desktop'])
                                        <i class="fas fa-desktop fa-2x text-secondary"></i>
                                        @else
                                        <i class="fas fa-mobile-alt fa-2x text-secondary"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm">
                                            {{ $session->agent['platform'] ? $session->agent['platform'] : 'Unknown' }}
                                            - {{ $session->agent['browser'] ? $session->agent['browser'] : 'Unknown' }}
                                        </div>
                                        <div class="text-xs text-muted">
                                            {{ $session->ip_address }},
                                            @if ($session->is_current_device)
                                            <span class="text-success font-weight-bold">This device</span>
                                            @else
                                            Last active {{ $session->last_active }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#logoutOtherBrowserSessionsModal">
                                Log Out Other Browser Sessions
                            </button>

                            <!-- Modal Logout -->
                            <div class="modal fade" id="logoutOtherBrowserSessionsModal" tabindex="-1" role="dialog"
                                aria-labelledby="logoutOtherBrowserSessionsModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{ route('admin.profile.browser-sessions.destroy') }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="logoutOtherBrowserSessionsModalLabel">Log
                                                    Out Other Browser Sessions</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Please enter your password to confirm you would like to log out of
                                                    your other browser sessions across all of your devices.
                                                </p>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Log Out Other Browser
                                                    Sessions</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="dropdown-divider mt-4"></div>

                            <!-- Delete Account -->
                            <div class="section-title text-danger">Delete Account</div>
                            <p class="text-muted">Permanently delete your account. Once your account is deleted, all of
                                its resources and data will be permanently deleted.</p>

                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteAccountModal">
                                Delete Account
                            </button>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog"
                                aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{ route('admin.profile.destroy') }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Are you sure you want to delete your account? Once your account is
                                                    deleted, all of its resources and data will be permanently deleted.
                                                    Please enter your password to confirm you would like to permanently
                                                    delete your account.
                                                </p>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete Account</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('admin/assets/bundles/sweetalert/sweetalert.min.js') }}"></script>
<script>
    function refresh2FASection() {
        console.log('Refreshing 2FA section...');
        return axios.get(window.location.href)
            .then(response => {
                console.log('Got response for 2FA refresh');
                const parser = new DOMParser();
                const doc = parser.parseFromString(response.data, 'text/html');
                const wrapper = doc.getElementById('two-factor-wrapper');
                const container = document.getElementById('two-factor-wrapper');
                
                if (wrapper && container) {
                    container.innerHTML = wrapper.innerHTML;
                    console.log('2FA section updated successfully');
                } else {
                    console.error('2FA Wrapper not found in response or DOM');
                    window.location.reload();
                }
            }).catch(error => {
                console.error('Error refreshing 2FA section:', error);
                window.location.reload();
            });
    }

    // Set axios CSRF token from meta tag
    function setupAxios() {
        if (typeof axios === 'undefined') {
            console.error('Axios is not loaded!');
            return false;
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            return true;
        }
        console.error('CSRF token not found!');
        return false;
    }

    function toggle2FA(action) {
        console.log('Toggling 2FA:', action);
        if (!setupAxios()) {
            swal('Error', 'Sistem gagal memuat pustaka yang diperlukan. Silakan refresh halaman.', 'error');
            return;
        }

        const btnId = action === 'enable' ? 'btn-enable-2fa' : 'btn-disable-2fa';
        let btn = document.getElementById(btnId) || document.getElementById('btn-cancel-2fa');
        
        if (btn) {
            btn.classList.add('btn-progress');
            btn.disabled = true;
        }

        const method = action === 'enable' ? 'post' : 'delete';
        const url = '{{ url("user/two-factor-authentication") }}';

        console.log('Sending request to:', url, 'method:', method);

        axios({
            method: method,
            url: url
        }).then(response => {
            console.log('2FA toggle success');
            return refresh2FASection();
        }).catch(error => {
            console.error('2FA Toggle Error:', error);
            if (btn) {
                btn.classList.remove('btn-progress');
                btn.disabled = false;
            }
            const message = error.response?.data?.message || 'Gagal memproses permintaan 2FA. Silakan coba lagi.';
            swal('Error', message, 'error');
        });
    }

    function confirm2FA() {
        if (!setupAxios()) return;

        const codeInput = document.getElementById('two_factor_code');
        const btn = document.getElementById('btn-confirm-2fa');
        const errorMsg = document.getElementById('confirm-error');

        if (!codeInput || !codeInput.value) return;

        btn.classList.add('btn-progress');
        btn.disabled = true;
        errorMsg.classList.add('d-none');

        axios.post('{{ route("two-factor.confirm") }}', {
            code: codeInput.value
        }).then(response => {
            return refresh2FASection().then(() => {
                swal('Success', 'Otentikasi dua faktor berhasil dikonfirmasi!', 'success');
            });
        }).catch(error => {
            console.error('2FA Confirm Error:', error);
            btn.classList.remove('btn-progress');
            btn.disabled = false;
            errorMsg.classList.remove('d-none');
            codeInput.focus();
        });
    }

    function regenerateRecoveryCodes() {
        if (!setupAxios()) return;

        const btn = document.getElementById('btn-regen-codes');
        if (btn) {
            btn.classList.add('btn-progress');
            btn.disabled = true;
        }

        axios.post('{{ route("two-factor.recovery-codes.store") }}')
            .then(response => {
                return refresh2FASection().then(() => {
                    swal('Success', 'Recovery codes berhasil diperbarui!', 'success');
                });
            })
            .catch(error => {
                console.error('2FA Regen Codes Error:', error);
                if (btn) {
                    btn.classList.remove('btn-progress');
                    btn.disabled = false;
                }
                swal('Error', 'Gagal memperbarui recovery codes.', 'error');
            });
    }
</script>
@endsection
