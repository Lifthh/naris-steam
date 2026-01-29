<!-- resources/views/kasir/transactions/print.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
            background: #f3f4f6;
            padding: 20px;
        }
        
        .receipt {
            width: 280px;
            margin: 0 auto;
            background: white;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ccc;
        }
        
        .store-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .store-info {
            font-size: 10px;
            color: #666;
        }
        
        .divider {
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .info-label {
            color: #666;
        }
        
        .info-value {
            font-weight: bold;
        }
        
        .section-title {
            font-weight: bold;
            margin: 10px 0 5px 0;
            padding-bottom: 3px;
            border-bottom: 1px solid #eee;
        }
        
        .item-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .item-name {
            flex: 1;
        }
        
        .item-price {
            text-align: right;
            min-width: 80px;
        }
        
        .addon-item {
            font-size: 11px;
            color: #666;
        }
        
        .total-section {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #333;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 3px;
        }
        
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .footer-message {
            margin-top: 10px;
            font-style: italic;
        }
        
        .qr-section {
            text-align: center;
            margin: 10px 0;
        }
        
        .print-btn {
            display: block;
            width: 280px;
            margin: 20px auto;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .print-btn:hover {
            background: #1d4ed8;
        }
        
        .back-btn {
            display: block;
            width: 280px;
            margin: 10px auto;
            padding: 12px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        
        .back-btn:hover {
            background: #4b5563;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .receipt {
                box-shadow: none;
                width: 100%;
                max-width: 280px;
            }
            
            .print-btn,
            .back-btn,
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="store-name">{{ $settings['store_name'] }}</div>
            @if($settings['store_address'])
                <div class="store-info">{{ $settings['store_address'] }}</div>
            @endif
            @if($settings['store_phone'])
                <div class="store-info">Telp: {{ $settings['store_phone'] }}</div>
            @endif
        </div>
        
        <!-- Transaction Info -->
        <div class="info-row">
            <span class="info-label">No:</span>
            <span class="info-value">{{ $transaction->invoice_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kasir:</span>
            <span>{{ $transaction->user->name }}</span>
        </div>
        
        <div class="divider"></div>
        
        <!-- Vehicle Info -->
        <div class="info-row">
            <span class="info-label">Plat:</span>
            <span class="info-value">{{ $transaction->plate_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Motor:</span>
            <span class="text-capitalize">{{ ucfirst($transaction->vehicle_type) }}</span>
        </div>
        @if($transaction->vehicle_brand)
            <div class="info-row">
                <span class="info-label">Merk:</span>
                <span>{{ $transaction->vehicle_brand }}</span>
            </div>
        @endif
        
        <div class="divider"></div>
        
        <!-- Services -->
        <div class="section-title">LAYANAN</div>
        @foreach($transaction->services as $service)
            <div class="item-row">
                <span class="item-name">{{ $service->service_name }}</span>
                <span class="item-price">{{ number_format($service->price, 0, ',', '.') }}</span>
            </div>
        @endforeach
        
        <!-- Addons -->
        @if($transaction->addons->count() > 0)
            <div class="section-title">TAMBAHAN</div>
            @foreach($transaction->addons as $addon)
                <div class="item-row addon-item">
                    <span class="item-name">+ {{ $addon->addon_name }}</span>
                    <span class="item-price">{{ number_format($addon->price, 0, ',', '.') }}</span>
                </div>
            @endforeach
        @endif
        
        <!-- Total -->
        <div class="total-section">
            <div class="total-row">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="payment-row">
                <span>Bayar ({{ $transaction->payment_method === 'cash' ? 'Tunai' : 'QRIS' }})</span>
                <span>Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
            </div>
            @if($transaction->payment_method === 'cash')
                <div class="payment-row">
                    <span>Kembali</span>
                    <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                </div>
            @endif
        </div>
        
        <!-- Notes -->
        @if($transaction->notes)
            <div class="divider"></div>
            <div style="font-size: 10px; color: #666;">
                <strong>Catatan:</strong> {{ $transaction->notes }}
            </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            <div>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</div>
            <div class="footer-message">{{ $settings['receipt_footer'] }}</div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <button class="print-btn no-print" onclick="window.print()">
        🖨️ Cetak Struk
    </button>
    
    <a href="{{ url()->previous() }}" class="back-btn no-print">
        ← Kembali
    </a>
    
    <script>
        // Auto print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>