<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết Đơn hàng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong>ID:</strong> {{ $order->id }}
                    </div>
                    <div class="mb-4">
                        <strong>Bánh:</strong> {{ $order->cake->name ?? 'N/A' }}
                        @if($order->cake && $order->cake->image_url)
                            <img src="{{ $order->cake->image_url }}" alt="{{ $order->cake->name }}" class="mt-2 w-32 h-32 object-cover rounded-md">
                        @else
                            [Image of Bánh]
                        @endif
                    </div>
                    <div class="mb-4">
                        <strong>Khách hàng:</strong> {{ $order->customer->name ?? 'N/A' }} ({{ $order->customer->email ?? 'N/A' }})
                    </div>
                    <div class="mb-4">
                        <strong>Số lượng:</strong> {{ $order->quantity }}
                    </div>
                    <div class="mb-4">
                        <strong>Tổng giá:</strong> {{ number_format($order->total_price, 2) }}
                    </div>
                    <div class="mb-4">
                        <strong>Trạng thái:</strong> {{ $order->status }}
                    </div>
                    <div class="mb-4">
                        <strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}
                    </div>
                    <div class="mb-4">
                        <strong>Ngày cập nhật:</strong> {{ $order->updated_at->format('d/m/Y H:i:s') }}
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
