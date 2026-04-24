<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .voucher-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .voucher-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .voucher-code {
            font-size: 32px;
            font-weight: bold;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            letter-spacing: 2px;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px 25px;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
            border: 2px dashed rgba(255, 255, 255, 0.5);
        }
        .order-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .order-info h3 {
            margin-top: 0;
            color: #1d1d1f;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
        }
        .info-value {
            color: #1d1d1f;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 14px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .magic-link {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            transition: background-color 0.3s ease;
        }
        .magic-link:hover {
            background-color: #0056b3;
        }
        .thank-you {
            font-size: 18px;
            color: #28a745;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 မှာယူတောင်းဆိုမှုအတည်ပြုလက်ခံပြီး</h1>
            <p>Order Confirmation - အော်ဒါအတည်ပြုလက်ခံပြီး</p>
        </div>

        <div class="content">
            <div class="thank-you">
                ကျေးဇူးတင်ပါသည်! Thank you for your order! 🙏
            </div>

            <div class="voucher-card">
                <h2 style="margin: 0 0 10px 0; font-size: 24px;">🎫 သင့်အမှတ်တမ်းကုဒ်</h2>
                <p style="margin: 0 0 20px 0; opacity: 0.9;">Your Receipt Code</p>
                <div class="voucher-code">{{ $order->receipt_code }}</div>
                <p style="margin: 10px 0 0 0; opacity: 0.8;">ဤကုဒ်ကိုသိမ်းဆည်းထားပါ | Please save this code</p>
            </div>

            <div class="order-info">
                <h3>📋 အော်ဒါအသေးစိတ် | Order Details</h3>
                
                <div class="info-row">
                    <span class="info-label">အမှတ်တမ်းကုဒ်:</span>
                    <span class="info-value">{{ $order->receipt_code }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">အမည်:</span>
                    <span class="info-value">{{ $order->name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">ဖုန်းနံပါတ်:</span>
                    <span class="info-value">{{ $order->phone }}</span>
                </div>
                
                @if($order->email)
                <div class="info-row">
                    <span class="info-label">အီးမေးလ်:</span>
                    <span class="info-value">{{ $order->email }}</span>
                </div>
                @endif
                
                @if($order->address)
                <div class="info-row">
                    <span class="info-label">ပို့ဆောင်လိပ်စာ:</span>
                    <span class="info-value">{{ $order->address }}</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="info-label">အခြေအနေ:</span>
                    <span class="info-value">
                        <span class="status-badge status-pending">
                            {{ $order->status == 'pending' ? 'စစ်ဆေးဆဲ' : ($order->status == 'verified' ? 'အတည်ပြုပြီး' : 'ငြင်းပယ်ပြီး') }}
                        </span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">တောင်းဆိုသည့်နေ့:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('order.magic', ['token' => $order->magic_token]) }}" class="magic-link">
                    📊 အော်ဒါအခြေအနေကြည့်ရှုရန် | Track Order Status
                </a>
            </div>

            <div style="background-color: #e7f3ff; border-left: 4px solid #007bff; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <h4 style="margin: 0 0 10px 0; color: #0056b3;">📝 အသိပေးချက် | Important Notice</h4>
                <p style="margin: 0; color: #333; font-size: 14px;">
                    သင့်အော်ဒါကို ကျွန်ုပ်တို့စစ်ဆေးပြီးနောက် ငွေပေးချေမှုအတည်ပြုပါက စာအုပ်များကို သင့်ပို့ဆောင်လိပ်စာသို့ ပို့ဆောင်ပေးပါမည်။<br>
                    We will deliver the books to your address after payment verification.
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>📚 Book Sale Platform</strong></p>
            <p>မြန်မာ့စာအုပ်အရောင်းပလက်ဖောင်း</p>
            <p style="font-size: 12px; margin-top: 15px;">
                ဤအီးမေးလ်ကို စက်ရုပ်မှ ထုတ်လုပ်ခြင်းဖြစ်ပါသည်။<br>
                This email was automatically generated.
            </p>
        </div>
    </div>
</body>
</html>
