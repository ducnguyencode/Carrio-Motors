@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số hóa đơn</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_invoices'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng doanh thu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($statistics['total_revenue'], 0, ',', '.') }} VNĐ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Hóa đơn đang xử lý</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['pending_invoices'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Hóa đơn đã hủy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['cancelled_invoices'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách hóa đơn -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách hóa đơn</h6>
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tạo hóa đơn mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="invoicesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã hóa đơn</th>
                            <th>Khách hàng</th>
                            <th>Nhân viên bán hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ $invoice->saler ? $invoice->saler->name : 'N/A' }}</td>
                            <td>{{ number_format($invoice->total_amount, 0, ',', '.') }} VNĐ</td>
                            <td>
                                <span class="badge badge-{{ $invoice->status_color }}">
                                    {{ $invoice->status_text }}
                                </span>
                            </td>
                            <td>{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($invoice->status !== 'completed')
                                <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#invoicesTable').DataTable({
            "order": [[5, "desc"]],
            "pageLength": 15,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
            }
        });
    });
</script>
@endpush
