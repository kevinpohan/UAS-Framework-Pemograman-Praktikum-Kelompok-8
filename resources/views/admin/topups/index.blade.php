@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-8">Manage Top-ups</h2>

        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="text-left py-4 px-6">User</th>
                            <th class="text-left py-4 px-6">Amount</th>
                            <th class="text-left py-4 px-6">Proof</th>
                            <th class="text-left py-4 px-6">Status</th>
                            <th class="text-left py-4 px-6">Date</th>
                            <th class="text-left py-4 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topups as $topup)
                        <tr class="border-t border-gray-700 hover:bg-gray-750">
                            <td class="py-4 px-6 font-bold">{{ $topup->user->name }}</td>
                            <td class="py-4 px-6">${{ number_format($topup->amount, 2) }}</td>

                            {{-- Menampilkan Bukti Pembayaran --}}
                            <td class="py-4 px-6">
                                @if($topup->proof)
                                <a href="{{ asset('storage/' . $topup->proof) }}" target="_blank" class="text-primary hover:underline">
                                    <i class="fas fa-file-image"></i> View
                                </a>
                                @else
                                N/A
                                @endif
                            </td>

                            <td class="py-4 px-6">
                                <span class="
                                            {{ $topup->status === 'pending' ? 'bg-yellow-600' : 
                                               ($topup->status === 'approved' ? 'bg-green-600' : 'bg-red-600') }}
                                            text-white px-2 py-1 rounded text-sm
                                        ">
                                    {{ ucfirst($topup->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">{{ $topup->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-4 px-6">
                                @if($topup->status === 'pending')
                                <form action="{{ route('admin.topups.approve', $topup) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm mr-2">Approve</button>
                                </form>
                                <form action="{{ route('admin.topups.reject', $topup) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">Reject</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($topups->hasPages())
            <div class="px-6 py-4 bg-gray-700">
                {{ $topups->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection