<meta charset="UTF-8">
<div style="width:100%; float:left; margin: 40px 0px;font-family: DejaVu Sans; line-height: 200%; font-size:12px">
    <p style="float: right; text-align: right; padding-right:20px; line-height: 140%">
        Ngày đặt hàng: {{ $order->created_at }}<br><br>
    </p>
    <div style="float: left; margin: 0 0 1.5em 0; ">
        <strong style="font-size: 18px;">{{ config('app.name', 'Ben Computer') }}</strong>
        <br />
        <strong>Địa chỉ:</strong> Số 7, Ngõ 92 đường Nguyễn Khánh Toàn, Cầu Giấy, Hà Nội.
        <br />
        <strong>Điện thoại:</strong> 0899 179 991
        <br />
        <strong>Website:</strong> ben.com.vn
        <br />
        <strong>Email:</strong> saleonline@ben.com.vn
    </div>
    <div style="clear:both"></div>
    <table style="width: 100%">
        <tr>
            <td valign="top" style="width: 65%">
                <h3 style="font-size: 14px;margin: 1.5em 0 1em 0;">Chi tiết đơn hàng</h3>
                <hr style="border: none; border-top: 2px solid #0975BD;" />

                <table style="margin: 0 0 1.5em 0;font-size: 12px;" width="100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $key => $item)
                            @php
                                $product = $item->product;
                            @endphp
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($product->title, 100, $end='...') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ currency_format($item->buying_price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3 style="font-size: 14px;margin: 0 0 1em 0;">Thông tin thanh toán</h3>
                <table style="font-size: 12px;width: 100%; margin: 0 0 1.5em 0;">
                    <tr>
                        <td style="padding: 5px 0px">Tổng giá sản phẩm:</td>
                        <td style="text-align:right">{{ currency_format($order->total_price) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;padding: 5px 0px">Phí vận chuyển:</td>
                        <td style="text-align:right;padding: 5px 0px">0</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0px"><strong>Tổng tiền:</strong></td>
                        <td style="text-align:right;padding: 5px 0px"><strong>
                                <p>{{ currency_format($order->promotion_price) }}</td>
                    </tr>
                </table>
                <h3 style="font-size: 14px;margin: 0 0 1em 0;">Ghi chú:</h3>
                <p style="line-height: 30px">{{ currency_format($order->total_price) }}</p>
            </td>
            <td valign="top" style="padding: 0px 20px">
                <h3 style="font-size: 14px;margin: 1.5em 0 1em 0;">Thông tin đơn hàng</h3>
                <hr style="border: none; border-top: 2px solid #0975BD;" />
                <div style="margin: 0 0 1em 0; padding: 1em; border: 1px solid #d9d9d9;">
                    <strong>Mã đơn hàng:</strong><br>#{{ $order->order_code }}<br>
                    <strong>Ngày đặt hàng:</strong><br>{{ $order->created_at }}<br>
                    <strong>Phương thức thanh toán</strong><br>{{ $order->payment == 'COD' ? 'Thanh toán khi nhận hàng' : '' }}{{ $order->payment == 'online' && $order->payment_status == \App\Enums\PaymentStatus::SUCCESS ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                    <br>
                    <strong>Phương thức vận chuyển</strong><br>Shipper
                </div>
                <h3 style="font-size: 14px;margin: 1.5em 0 1em 0;">Thông tin mua hàng</h3>
                <hr style="border: none; border-top: 2px solid #0975BD;" />
                <div style="margin: 0 0 1em 0; padding: 1em; border: 1px solid #d9d9d9;  white-space: normal;">
                    <strong>{{ $order->shipping->customer_name }}</strong><br />{{ $order->shipping->customer_name }}<br />
                    Điện thoại: {{ $order->shipping->phone }}<br />
                    Địa chỉ: {{ $order->shipping->address }} <br>
                                    {{ $order->shipping->ward->type }} {{ $order->shipping->ward->name }},
                                    {{ $order->shipping->district->type }} {{ $order->shipping->district->name }},
                                    {{ $order->shipping->province->type }} {{ $order->shipping->province->name }}
                </div>
            </td>
        </tr>
    </table>
    <p>Nếu bạn có thắc mắc, vui lòng liên hệ chúng tôi qua email <u>0899 179 991</u> hoặc saleonline@ben.com.vn</p>
</div>
