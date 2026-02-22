@php $extend = (auth()->user()->type == 'user')? 'frontend.layouts.app' :  'backend.layouts.app'; @endphp

@extends($extend)

@section('title', __('Change Password'))

@section('content')
<style>
    .password-page {
        min-height: 100vh;
        background: #f5f6fa;
        padding-bottom: 100px;
    }

    .password-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 32px 20px 40px;
        text-align: center;
    }

    .password-hero-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 1.5rem;
        color: white;
    }

    .password-hero-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: white;
        margin-bottom: 4px;
    }

    .password-hero-subtitle {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.7);
    }

    .password-sections {
        padding: 0 16px;
        margin-top: -20px;
        position: relative;
        z-index: 1;
    }

    .password-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        padding: 24px 16px;
        margin-bottom: 16px;
    }

    .form-field {
        margin-bottom: 16px;
    }

    .form-field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }

    .form-field .form-input {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #e8e8e8;
        border-radius: 10px;
        font-size: 0.9rem;
        color: #1a1a2e;
        background: #fafbfc;
        transition: border-color 0.2s, background 0.2s;
        outline: none;
    }

    .form-field .form-input:focus {
        border-color: #667eea;
        background: white;
    }

    .form-field .field-error {
        font-size: 0.75rem;
        color: #e53e3e;
        margin-top: 4px;
    }

    .password-actions {
        display: flex;
        gap: 10px;
        margin-top: 24px;
    }

    .btn-save-pw {
        flex: 1;
        padding: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn-save-pw:hover { opacity: 0.9; }

    .btn-back-pw {
        padding: 12px 20px;
        background: #f5f6fa;
        color: #666;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .btn-back-pw:hover { background: #eee; color: #666; text-decoration: none; }

    .success-alert {
        background: #f0fff4;
        color: #22543d;
        border: 1px solid #c6f6d5;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.85rem;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (min-width: 768px) {
        .password-page { padding-top: 20px; }
        .password-sections { max-width: 480px; margin-left: auto; margin-right: auto; }
        .password-hero { max-width: 480px; margin: 0 auto; border-radius: 0 0 20px 20px; }
    }
</style>

<div class="password-page">
    <div class="password-hero">
        <div class="password-hero-icon">
            <i class="ni ni-lock-alt"></i>
        </div>
        <div class="password-hero-title">{{ __('Change Password') }}</div>
        <div class="password-hero-subtitle">{{ __('Keep your account secure') }}</div>
    </div>

    <div class="password-sections">
        @livewire('account.update-password')
    </div>
</div>
@endsection
