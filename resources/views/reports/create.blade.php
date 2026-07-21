@extends('layouts.app')

@section('title', 'New Report')

@section('content')

    <div class="page-header">
        <div>
            <h1>New Report</h1>
            <p>Add a new report entry to the system</p>
        </div>
    </div>

    <div class="card" style="max-width: 500px;">
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:6px; font-size:0.85rem; font-weight:600;">Type</label>
                <input type="text" name="type" value="{{ old('type') }}" placeholder="e.g. Inventory, Financial"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid var(--border);">
                @error('type') <div style="color:red; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:6px; font-size:0.85rem; font-weight:600;">Submitted By</label>
                <input type="text" name="submitted_by" value="{{ old('submitted_by') }}" placeholder="Full name"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid var(--border);">
                @error('submitted_by') <div style="color:red; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:6px; font-size:0.85rem; font-weight:600;">Status</label>
                <select name="status" style="width:100%; padding:10px; border-radius:8px; border:1px solid var(--border);">
                    <option value="approved">Approved</option>
                    <option value="pending">Pending</option>
                    <option value="flagged">Flagged</option>
                </select>
                @error('status') <div style="color:red; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">Save Report</button>
        </form>
    </div>

@endsection