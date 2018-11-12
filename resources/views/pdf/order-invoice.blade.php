<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{trans('pdf.title')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-size:12px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .lines {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .discount-seperator {
            color:#ccc;
        }
        .lines-heading {
            text-align: left;
            background-color: #ededed;
        }

        .lines-heading th {
            padding: 5px 10px;
            border: 1px solid #ccc;
        }

        .lines-body td {
            padding: 5px 10px;
            border: 1px solid #ededed;
        }

        .lines-footer {
            border-top:5px solid #f5f5f5;
            text-align:right;
        }

        .lines-footer td {
            padding: 10px;
            border: 1px solid #ededed;
        }

        .summary {
            margin-bottom: 40px;
        }

        .summary td {
            padding: 5px 10px;
        }

        .info {
            color:#0099e5;
        }

        .summary .total td {
            border-top: 1px solid #ccc;
        }


    </style>
</head>

<body>
    <div class="content">
        <div class="invoice-box">

            <table cellpadding="0" cellspacing="0" width="100%">
                <tr class="top">
                    <td>
                        <table width="100%">
                            <tr>
                                <td class="title" align="left" width="50%">
                                    <img src="{{ url('/images/logo.png') }}" width="100px">
                                    <h3>{{trans('pdf.orderInvoice')}}</h3>
                                </td>
                                <td align="right" width="50%">
                                    {{trans('pdf.invoice')}}: {{ @$order->invoice_reference }} <br>
                                    {{trans('pdf.created')}}: {{ $order->created_at }}<br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td align="left" width="33%">
                                    <h3>{{trans('pdf.billing')}}</h3>
                                    {{ $order->billing_firstname }} {{ @$order->billing_lastname }}<br>
                                    {{ $order->billing_address }}
                                    @if ($order->billing_address_two)
                                        {{ $order->billing_address_two }} <br>
                                    @endif
                                    @if ($order->billing_address_three)
                                        {{ $order->billing_address_three }} <br>
                                    @endif
                                    {{ $order->billing_city }}<br>
                                    {{ $order->billing_county }}<br>
                                    {{ $order->billing_state }}<br>
                                    {{ $order->billing_zip }}<br>
                                    {{ $order->billing_country }}
                                    @if($order->vat_no)
                                        <p>{{trans('pdf.VATNo')}}: {{ $order->vat_no }}</p>
                                    @endif
                                </td>

                                <td align="left" width="33%">
                                    <h3>{{trans('pdf.shipping')}}</h3>
                                    {{ $order->shipping_firstname }} {{ @$order->shipping_lastname }}<br>
                                    {{ $order->shipping_address }}
                                    @if ($order->shipping_address_two)
                                        {{ $order->shipping_address_two }} <br>
                                    @endif
                                    @if ($order->shipping_address_three)
                                        {{ $order->shipping_address_three }} <br>
                                    @endif
                                    {{ $order->shipping_city }}<br>
                                    {{ $order->shipping_county }}<br>
                                    {{ $order->shipping_state }}<br>
                                    {{ $order->shipping_zip }}<br>
                                    {{ $order->shipping_country }}
                                </td>

                                <td align="right" width="33%">
                                    <strong>{{ $settings['address']['address'] }}</strong><br>
                                    {{ $settings['address']['address_two'] }}<br>
                                    {{ $settings['address']['city'] }}<br>
                                    {{ $settings['address']['state'] }}<br>
                                    {{ $settings['address']['zip'] }}<br>
                                    {{ $settings['address']['country'] }}<br>
                                    @if($settings['tax']['vat_number'])
                                    <p>{{trans('pdf.VATNo')}}: {{ $settings['tax']['vat_number'] }}</p>
                                    @endif
                                    @if($settings['contact']['telephone'])
                                    <p>{{trans('pdf.telNo')}}: {{ $settings['contact']['telephone'] }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" width="100%" class="lines">
                <thead class="lines-heading">
                    <tr width="100%">
                        <th width="35%">
                            {{trans('pdf.Product')}}
                        </th>
                        <th width="28%">
                            {{trans('pdf.SKU')}}
                        </th>
                        <th width="10%">
                            {{trans('pdf.Qty')}}
                        </th>
                        <th width="15%">
                            {{trans('pdf.unitPrice')}}
                        </th>
                        <th width="15%">
                            {{trans('pdf.discount')}}
                        </th>
                        <th width="15%">
                            {{trans('pdf.taxRate')}}
                        </th>
                        <th width="15%">
                            {{trans('pdf.taxAmount')}}
                        </th>
                        <th width="12%">
                            {{trans('pdf.lineTotal')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="lines-body">
                    @foreach ($order->lines as $item)
                    <tr>
                        <td>
                            {{ $item->description }} <br>
                            @if ($item->product != $item->variant)
                                <small>{{ $item->variant }}</small>
                            @endif
                        </td>
                        <td>
                            {{ $item->sku }}
                        </td>
                        <td>
                            {{ $item->quantity }}
                        </td>
                        <td>
                            {!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format($item->unit_price / 100, 2) }}
                        </td>
                        <td>
                            {!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format($item->discount_total / 100, 2) }}
                        </td>
                        <td>VAT @ {{ $item->tax_rate }}%</td>
                        <td>
                            {!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format($item->tax_total / 100, 2) }}
                        </td>
                        <td align="right">
                            {!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format($item->line_total / 100, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="lines-footer">
                    @if($order->discounts)
                        @foreach ($order->discounts as $discount)
                            <tr class="discount-row">
                                <td colspan="4">
                                    <strong>{{ $discount->name }}</strong> @if($discount->type == 'percentage') @ {{ $discount->amount }}%@endif {{trans('pdf.discount')}}<br>
                                    @if ($discount->coupon)
                                    {{trans('pdf.code')}}: <code>{{ $discount->coupon }}</code>
                                    @endif
                                </td>
                                <td>-{{ $order->currency == 'GBP' ? '&pound;' : '&yen;' }}{{ number_format($discount->total, 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2">
                            <strong>{{trans('pdf.shipping')}}</strong> <br>
                            <small>{{ $order->shipping_method }}</small>
                        </td>
                        <td>{!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format($order->shipping_total / 100, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><strong>{{trans('pdf.subTotal')}}</strong></td>
                        <td>{!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format($order->sub_total / 100, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><strong>{{trans('pdf.VAT')}}</strong></td>
                        <td>{!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format($order->tax_total / 100, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><strong>{{trans('pdf.total')}}</strong></td>
                        <td>{!! $order->currency == 'GBP' ? '&pound;' : '&yen;' !!}{{ number_format(($order->sub_total + $order->tax_total) / 100, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            @if($order->notes)
            <p><strong>{{trans('pdf.orderNotes')}}</strong><br>
            {{ $order->notes }}</p>
            <br>
            @endif
        </div>
    </div>
</body>
</html>
