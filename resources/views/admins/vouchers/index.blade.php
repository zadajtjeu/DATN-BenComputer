@extends('layouts.admin')

@section('title') {{ __('Voucher Management') }} @endsection

@section('page_title')
{{ __('Voucher Management') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('Voucher Management') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-user-tag"></i>
                    {{ __('Vouchers') }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.vouchers.create')}}" class="btn btn-success my-2">{{ __('Create') }}</a>
                </div>
            </div>
            <div class="card-body p-1">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Voucher') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Value') }}</th>
                            <th>{{ __('Content') }}</th>
                            <th>{{ __('Valid Time') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($vouchers->isNotEmpty())
                            @foreach ($vouchers as $key => $voucher)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="{{ $voucher->code }}" title="{{ __('Copy to clipboard') }}"><i class="far fa-clipboard"></i></button>
                                        {{ $voucher->code }}
                                    </td>
                                    <td>
                                        {{ $voucher->quantity }}
                                        @if ($voucher->used > 0)
                                            <span class="badge bg-info">{{ $voucher->used }} {{ __('used') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($voucher->condition == \App\Enums\VoucherCondition::PERCENT)
                                            <span class="text-info">{{ $voucher->value }} <i class="fas fa-percent"></i></span>
                                        @elseif ($voucher->condition == \App\Enums\VoucherCondition::AMOUNT)
                                            <span class="text-success">{{ currency_format($voucher->value) }} <i class="far fa-money-bill-alt"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $voucher->title }}
                                    </td>
                                    <td>
                                        @if (\Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($voucher->end_date)))
                                            <span class="text-danger">{{ __('Expired') }}</span>
                                        @elseif (\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($voucher->start_date)))
                                            <span class="text-primary">{{ __('Effective') }} {{ \Carbon\Carbon::parse($voucher->start_date)->diffForHumans() }}</span>
                                        @else
                                            <span class="text-warning">{{ __('Expiring') }} {{ \Carbon\Carbon::parse($voucher->end_date)->diffForHumans() }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($voucher->status == \App\Enums\VoucherStatus::BLOCK)
                                            <span class="text-danger"> {{ __('Block') }} </span>
                                        @elseif ($voucher->status == \App\Enums\VoucherStatus::AVAILABLE)
                                            <span class="text-success"> {{ __('Active') }} </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.vouchers.edit', $voucher->id)}}" class="btn btn-primary">{{ __('Edit') }}</a>

                                        <form style="display: inline;" action="{{ route('admin.vouchers.destroy', $voucher->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('{{ __('Comfirm Delete') }}');">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                                <div class="alert alert-primary" role="alert">{{ __('Empty') }}</div>
                        @endif
                    </tbody>
                </table>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    </div>
</div>
@endsection

@section('addjs')
<script>
    // COPY TO CLIPBOARD
    // Attempts to use .execCommand('copy') on a created text field
    // Falls back to a selectable alert if not supported
    // Attempts to display status in Bootstrap tooltip
    // ------------------------------------------------------------------------------
    function copyToClipboard(text, el) {
        var copyTest = document.queryCommandSupported('copy');
        var elOriginalText = el.attr('data-original-title');

        if (copyTest === true) {
            var copyTextArea = document.createElement("textarea");
            copyTextArea.value = text;
            document.body.appendChild(copyTextArea);
            copyTextArea.select();
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? '{{ __('Copied!') }}' : '{{ __('Whoops, not copied!') }}';
                el.attr('data-original-title', msg).tooltip('show');
            } catch (err) {
                console.log('{{ __('Oops, unable to copy') }}');
            }
            document.body.removeChild(copyTextArea);
            el.attr('data-original-title', elOriginalText);
        } else {
            // Fallback if browser doesn't support .execCommand('copy')
            window.prompt("{{ __('Copy to clipboard: Ctrl+C or Command+C, Enter') }}", text);
        }
    }

    $(document).ready(function() {
        // Initialize
        // ---------------------------------------------------------------------

        // Tooltips
        // Requires Bootstrap 3 for functionality
        $('.js-tooltip').tooltip();

        // Copy to clipboard
        // Grab any text in the attribute 'data-copy' and pass it to the
        // copy function
        $('.js-copy').click(function() {
            var text = $(this).attr('data-copy');
            var el = $(this);
            copyToClipboard(text, el);
        });
    });
</script>
@endsection
