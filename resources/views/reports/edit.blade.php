@extends('layouts.app')

@section('title', 'Edit Report')

@section('content')

    <div class="page-header">
        <div>
            <h1>Edit Report</h1>
            <p>Update this report entry</p>
        </div>
    </div>

    <div class="card" style="max-width: 500px;">
        <form method="POST" action="{{ route('reports.update', $report->id) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:6px; font-size:0.85rem; font-weight:600;">Type</label>
                <input type="text" name="type" value="{{ old('type', $report->type) }}"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid var(--border);">
                @error('type') <div style="color:red; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:6px; font-size:0.85rem; font-weight:600;">Submitted By</label>
                <input type="text" name="submitted_by" value="{{ old('submitted_by', $report->submitted_by) }}"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid var(--border);">
                @error('submitted_by') <div style="color:red; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom:6px; font-size:0.85rem; font-weight:600;">Status</label>
                <select name="status" style="width:100%; padding:10px; border-radius:8px; border:1px solid var(--border);">
                    <option value="approved" {{ $report->status === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="flagged" {{ $report->status === 'flagged' ? 'selected' : '' }}>Flagged</option>
                </select>
                @error('status') <div style="color:red; font-size:0.8rem; margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">Update Report</button>
        </form>
    </div>

@endsection