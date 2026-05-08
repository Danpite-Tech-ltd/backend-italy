@extends('admin.layout.app')

@push('css')
    <style>
        .status-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .status-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .status-card.active {
            border-color: #007bff;
            background-color: #f0f7ff;
        }

        .status-card.pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
        }

        .status-card.approved {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        }

        .status-card.rejected {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        }

        .card-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .card-label {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-approved {
            background-color: #28a745;
            color: #fff;
        }

        .badge-rejected {
            background-color: #dc3545;
            color: #fff;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons button,
        .action-buttons a {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid py-4">
        <!-- Status Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card status-card pending {{ $status == 'pending' ? 'active' : '' }}"
                    onclick="filterByStatus('pending')">
                    <div class="card-body text-center">
                        <div class="card-label">Pending</div>
                        <div class="card-value">{{ $pendingCount }}</div>
                        <small class="text-muted">Awaiting Approval</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card status-card approved {{ $status == 'approved' ? 'active' : '' }}"
                    onclick="filterByStatus('approved')">
                    <div class="card-body text-center">
                        <div class="card-label">Approved</div>
                        <div class="card-value">{{ $approvedCount }}</div>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card status-card rejected {{ $status == 'rejected' ? 'active' : '' }}"
                    onclick="filterByStatus('rejected')">
                    <div class="card-body text-center">
                        <div class="card-label">Rejected</div>
                        <div class="card-value">{{ $rejectedCount }}</div>
                        <small class="text-muted">Declined</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawals Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 card-title">
                                {{ ucfirst($status) }} Withdrawals
                            </h4>
                            <span class="badge badge-{{ $status }}">
                                {{ count($withdraws) }} Records
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($withdraws->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Vendor</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th>Admin Note</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdraws as $key => $withdraw)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>
                                                    @if ($withdraw->vendor)
                                                        {{ $withdraw->vendor->first_name ?? 'N/A' }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong class="text-primary">
                                                        ৳ {{ number_format($withdraw->amount, 2) }}
                                                    </strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $withdraw->status }}">
                                                        {{ ucfirst($withdraw->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{ $withdraw->note ?? '-' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{ $withdraw->admin_note ?? '-' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{ $withdraw->created_at->format('d M Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    @if ($status === 'pending')
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#updateModal"
                                                            onclick="setWithdrawData({{ $withdraw->id }}, '{{ $withdraw->status }}', '{{ addslashes($withdraw->admin_note) }}', {{ $withdraw->amount }}, {{ $withdraw->vendor->id }}, '{{ $withdraw->account_name ?? '' }}', '{{ $withdraw->bank_name ?? '' }}', '{{ $withdraw->branch_name ?? '' }}', '{{ $withdraw->account_number ?? '' }}')">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    @else
                                                        <span class="badge bg-secondary">Read Only</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle"></i> No {{ $status }} withdrawals found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Withdrawal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateForm">
                        @csrf
                        <input type="hidden" id="withdrawId" name="id">
                        <input type="hidden" id="withdrawAmount" name="amount">
                        <input type="hidden" id="withdrawVendorId" name="vendor_id">

                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Status</label>
                            <select class="form-select" id="statusSelect" name="status">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="adminNote" class="form-label">Admin Note</label>
                            <textarea class="form-control" id="adminNote" name="admin_note" rows="3" placeholder="Add your notes here..."></textarea>
                        </div>

                        <div class="mb-3 p-3 bg-light rounded">
                            <h6 class="mb-3 text-muted">Bank Details</h6>
                            <p class="mb-2"><strong>Account Name:</strong> <span id="displayAccountName">-</span></p>
                            <p class="mb-2"><strong>Bank Name:</strong> <span id="displayBankName">-</span></p>
                            <p class="mb-2"><strong>Branch Name:</strong> <span id="displayBranchName">-</span></p>
                            <p class="mb-0"><strong>Account Number:</strong> <span id="displayAccountNumber">-</span></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateWithdraw()">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function filterByStatus(status) {
            window.location.href = "{{ route('admin.withdraw') }}?status=" + status;
        }

        function setWithdrawData(id, status, adminNote, amount, vendorId, accountName, bankName, branchName,
        accountNumber) {
            document.getElementById('withdrawId').value = id;
            document.getElementById('statusSelect').value = status;
            document.getElementById('adminNote').value = adminNote || '';
            document.getElementById('withdrawAmount').value = amount || '';
            document.getElementById('withdrawVendorId').value = vendorId || '';

            // Display bank details
            document.getElementById('displayAccountName').textContent = accountName || '-';
            document.getElementById('displayBankName').textContent = bankName || '-';
            document.getElementById('displayBranchName').textContent = branchName || '-';
            document.getElementById('displayAccountNumber').textContent = accountNumber || '-';
        }

        function updateWithdraw() {
            const form = document.getElementById('updateForm');
            const formData = new FormData(form);

            fetch("{{ route('admin.withdraw.update.status') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                            document.querySelector('input[name="_token"]')?.value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Something went wrong',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Close modal after update
        document.getElementById('updateModal')?.addEventListener('hidden.bs.modal', function() {
            document.getElementById('updateForm').reset();
        });
    </script>
@endpush
