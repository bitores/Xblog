@extends('user.user')
@section('title', 'Notifications')
@section('user-content')
    <div class="p-3">
        @if($notifications->isEmpty())
            <h5 class="text-secondary text-center mt-3">No Notifications</h5>
        @else
            <table class="table table-striped table-hover table-bordered table-responsive">
                <thead>
                <tr>
                    <th>用户</th>
                    <th>Email</th>
                    <th>类型</th>
                    <th>内容</th>
                    <th>IP</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notifications as $notification)
                    @if($notification->data)
                        <?php $notificationData = $notification->data?>
                        <tr class="">
                            <td>
                                @if($notificationData['user_id'])
                                    <a href="{{ route('user.show',$notificationData['username']) }}">{{ $notificationData['username'] }}</a>
                                @else
                                    {{ $notificationData['username'] }}
                                @endif
                            </td>
                            <td>
                                <a href="mailto:{{ $notificationData['email'] }}">{{ $notificationData['email'] }}</a>
                            </td>
                            <td>
                                @if("App\\Notifications\\ReceivedComment" == $notification->type)
                                    评论
                                @elseif("App\\Notifications\\MentionedInComment" == $notification->type)
                                    提到了你
                                @elseif("App\\Notifications\\BaseNotification" == $notification->type)
                                    基本提醒
                                @endif
                            </td>
                            <td data-toggle="tooltip" data-placement="top">{!! $notificationData['html_content'] !!}</td>
                            <td>{{ $notificationData['ip_id']?$notificationData['ip_id']:'NONE' }}</td>
                            <td>
                                @if($notification->read_at)
                                    <button class="btn btn-secondary">已读</button>
                                @else
                                    <a class="btn btn-success" href="{{ route('user.read_notification',$notification->id) }}">已读</a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <a class="btn-block btn btn-outline-success mt-3" href="{{ route('user.read_notification',"all") }}">
                <i class="fa fa-eye fw mr-2"></i>全部已读
            </a>
            <button class="btn-block btn btn-outline-danger mt-3 swal-dialog-target"
                    data-dialog-msg="Delete {{ $readNotificationsCount }} read notifications?"
                    data-url="{{ route('user.delete_read_notifications') }}"
                    data-method="delete">
                <i class="fa fa-trash fw mr-2"></i>删除已读<span class="badge badge-danger">{{ $readNotificationsCount }}</span>
            </button>
        @endif
    </div>
@endsection
