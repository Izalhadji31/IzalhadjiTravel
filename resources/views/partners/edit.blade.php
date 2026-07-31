@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 30px auto; padding: 0 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Page Header -->
    <div style="margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 28px; color: #1e293b; font-weight: 700;">Edit Partner</h1>
        <p style="margin: 5px 0 0; color: #64748b; font-size: 14px;">Update partner information</p>
    </div>

    <!-- Edit Form Card -->
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 30px; border: 1px solid #e2e8f0;">
        <form action="{{ route('partners.update', $partner) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- General Information Section -->
            <h2 style="margin: 0 0 20px; font-size: 16px; color: #1e293b; font-weight: 600; border-bottom: 2px solid #2563eb; padding-bottom: 8px;">General Information</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <!-- Name -->
                <div style="margin-bottom: 5px;">
                    <label for="name" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $partner->name) }}" required
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('name')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div style="margin-bottom: 5px;">
                    <label for="email" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Email <span style="color: #ef4444;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $partner->email) }}" required
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('email')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div style="margin-bottom: 5px;">
                    <label for="phone" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $partner->phone) }}"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('phone')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- City -->
                <div style="margin-bottom: 5px;">
                    <label for="city" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $partner->city) }}"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('city')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Address (full width) -->
                <div style="margin-bottom: 5px; grid-column: 1 / -1;">
                    <label for="address" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Address</label>
                    <textarea id="address" name="address" rows="3"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none; resize: vertical;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">{{ old('address', $partner->address) }}</textarea>
                    @error('address')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Bank Information Section -->
            <h2 style="margin: 0 0 20px; font-size: 16px; color: #1e293b; font-weight: 600; border-bottom: 2px solid #2563eb; padding-bottom: 8px;">Bank Information</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <!-- Bank Name -->
                <div style="margin-bottom: 5px;">
                    <label for="bank_name" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $partner->bank_name) }}"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('bank_name')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bank Account -->
                <div style="margin-bottom: 5px;">
                    <label for="bank_account" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Bank Account</label>
                    <input type="text" id="bank_account" name="bank_account" value="{{ old('bank_account', $partner->bank_account) }}"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('bank_account')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Bank Holder -->
                <div style="margin-bottom: 5px;">
                    <label for="bank_holder" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Bank Holder</label>
                    <input type="text" id="bank_holder" name="bank_holder" value="{{ old('bank_holder', $partner->bank_holder) }}"
                        style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('bank_holder')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Revenue Share Section -->
            <h2 style="margin: 0 0 20px; font-size: 16px; color: #1e293b; font-weight: 600; border-bottom: 2px solid #2563eb; padding-bottom: 8px;">Revenue Share</h2>
            <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 30px;">
                <div style="margin-bottom: 5px;">
                    <label for="revenue_share_percentage" style="display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 6px;">Revenue Share Percentage (%)</label>
                    <input type="number" id="revenue_share_percentage" name="revenue_share_percentage" value="{{ old('revenue_share_percentage', $partner->revenue_share_percentage) }}" min="0" max="100" step="0.01"
                        style="width: 100%; max-width: 300px; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; color: #1e293b; background-color: #fff; transition: border-color 0.2s; box-sizing: border-box; outline: none;"
                        onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                        onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                    @error('revenue_share_percentage')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <a href="{{ route('partners.show', $partner) }}" style="display: inline-block; padding: 10px 24px; background-color: #f1f5f9; color: #334155; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 600; transition: background-color 0.2s;">Cancel</a>
                <button type="submit" style="padding: 10px 24px; background-color: #2563eb; color: #fff; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;">Update Partner</button>
            </div>
        </form>
    </div>
</div>
@endsection
