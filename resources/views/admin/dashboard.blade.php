@extends('layouts.admin')

@section('title', 'Tổng quan')
@section('page_title', 'Bảng điều khiển')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="card-airbnb p-8 relative group overflow-hidden border border-[#f2f2f2]">
            <h3 class="text-secondary-gray text-[10px] font-bold uppercase mb-2">Doanh thu hệ thống</h3>
            <p class="text-3xl font-bold text-near-black tracking-tighter">{{ number_format($stats['total_revenue']) }}đ</p>
            <div class="mt-4">
                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md uppercase">
                    Đã thanh toán
                </span>
            </div>

        </div>

        
        <div class="card-airbnb p-8 relative group overflow-hidden border border-slate-50">
            <h3 class="text-secondary-gray text-[10px] font-bold uppercase mb-2">Đơn hàng mới</h3>
            <p class="text-3xl font-bold text-near-black tracking-tighter">{{ number_format($stats['total_orders']) }}</p>
            <div class="mt-4">
                <span class="text-[10px] font-bold text-primary bg-primary/5 px-2 py-1 rounded-md uppercase">{{ $stats['pending_orders'] }} ĐƠN CHỜ DUYỆT</span>
            </div>
        </div>

        
        <div class="card-airbnb p-8 relative group overflow-hidden border border-slate-50">
            <h3 class="text-secondary-gray text-[10px] font-bold uppercase mb-2">Cảnh báo tồn kho</h3>
            <p class="text-3xl font-bold text-primary tracking-tighter">{{ $stats['low_stock_products'] }}</p>
            <div class="mt-4 italic">
                <a href="{{ route('admin.products.index') }}" class="text-[10px] font-bold text-secondary-gray hover:text-near-black uppercase border-b border-[#ebebeb] pb-0.5">Kiểm kho ngay →</a>
            </div>
        </div>

        
        <div class="card-airbnb p-8 relative group overflow-hidden border border-slate-50">
            <h3 class="text-secondary-gray text-[10px] font-bold uppercase mb-2">Tổng khách hàng</h3>
            <p class="text-3xl font-bold text-near-black tracking-tighter">{{ number_format($stats['total_customers']) }}</p>
            <div class="mt-4">
                <span class="text-[10px] font-bold text-secondary-gray border border-[#f2f2f2] px-2 py-1 rounded-md uppercase">Active Members</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8">
        
        <div class="lg:col-span-2 card-airbnb p-10 flex flex-col border border-slate-50">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl font-bold text-near-black tracking-tight">Xu hướng doanh thu</h2>
                    <p class="text-secondary-gray text-xs font-semibold mt-1">Dữ liệu thống kê 6 tháng gần nhất.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-near-black uppercase">VNĐ / Tháng</span>
                </div>
            </div>
            <div class="flex-1 min-h-[350px] relative">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>


        <div class="lg:col-span-3 card-airbnb overflow-hidden border border-slate-50">
            <div class="p-10 border-b border-[#f2f2f2] flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-near-black tracking-tight">Giao dịch gần đây</h2>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 bg-near-black text-white rounded-md text-xs font-bold uppercase hover:bg-primary">Chi tiết kho</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-10 py-5 text-[10px] font-bold uppercase text-secondary-gray">Hash / ID</th>
                            <th class="px-10 py-5 text-[10px] font-bold uppercase text-secondary-gray">Customer</th>
                            <th class="px-10 py-5 text-[10px] font-bold uppercase text-secondary-gray">Status</th>
                            <th class="px-10 py-5 text-[10px] font-bold uppercase text-secondary-gray text-right">Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f2f2f2]">
                        @forelse($recent_orders as $order)
                        <tr class="hover:bg-slate-50/30 group">
                            <td class="px-10 py-5">
                                <span class="font-bold text-near-black text-sm">#{{ $order->id }}</span>
                            </td>
                            <td class="px-10 py-5">
                                <p class="text-sm font-bold text-near-black">{{ $order->full_name }}</p>
                                <p class="text-[10px] text-secondary-gray font-bold uppercase mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-10 py-5">
                                <span class="inline-block px-3 py-1 rounded-md bg-[#f7f7f7] text-near-black text-[9px] font-bold uppercase border border-[#ebebeb]">
                                    {{ $order->status_label ?? 'PROCESSING' }}
                                </span>
                            </td>
                            <td class="px-10 py-5 text-right font-bold text-near-black text-sm leading-none">{{ number_format($order->total_price) }}đ</td>
                        </tr>
                        @empty
                        <tr>
                             <td colspan="4" class="p-20 text-center text-secondary-gray/50 italic font-medium">No transactions found in this cycle.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),

                datasets: [{
                    label: 'Doanh thu',
                    data: @json($revenue_data),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0,
                    fill: true
                }]
            },
            options: {
                animation: false,
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#18181b',
                        titleFont: {
                            size: 12,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f4f4f5'
                        },
                        ticks: {
                            font: {
                                size: 10,
                                weight: '600'
                            },
                            color: '#a1a1aa',
                            callback: function(value) {
                                return (value / 1000000) + 'M';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10,
                                weight: '600'
                            },
                            color: '#a1a1aa'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection