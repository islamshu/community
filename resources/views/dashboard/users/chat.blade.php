@extends('layouts.backend')

@section('content')
<div class="sidebar-left sidebar-fixed">
    <div class="sidebar">
      <div class="sidebar-content card d-none d-lg-block">
        
        <div id="users-list" class="list-group position-relative">
          <div class="users-list-padding media-list">
              @foreach ($users as $item)

            <a href="{{ route('show_message_from_user',[$item->id,$user]) }}" class="media border-0">
              <div class="media-left pr-1">
                <span class="avatar avatar-md avatar-online">
                  <img class="media-object rounded-circle" src="{{ asset('uploads/'.$item->image) }}"
                  alt="Generic placeholder image">
                  <i></i>
                </span>
              </div>
              <div class="media-body w-100">
                <h6 class="list-group-item-heading">{{ $item->name }}
                </h6>
             
              </div>
            </a>
            @endforeach
          
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-right" style="max-height: 600px;overflow: auto">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="chat-app-window">
          <div class="badge badge-default mb-1">Chat History</div>
          <div class="chats">
            <div class="chats">
                @foreach ($messages as $item)
                @if ($item->receiver_id != $sender->id)

               <div class="chat"  style="background: #dadada;border-radius: 5px; margin-top:1px ;margin-bottom: 1px">
                <div class="chat-avatar">
                  <a class="avatar" data-toggle="tooltip" data-placement="right" title=""
                  data-original-title="">
                    <img src="{{ asset('uploads/'.$sender->image) }}" alt="avatar"
                    />{{ $sender->name }}
                  </a>
                </div>
                <div class="chat-body" style="padding: 10px">
                  <div class="chat-content" style="padding: 10px">
                    <p>{{ $item->message }}</p>
                    <span class="text-muted fs-7 mb-1">{{ $item->created_at->diffForHumans() }}</span>

                  </div>
                </div>
              </div>
              @else
              <div class="chat chat-left" style="background: #dad1d1;border-radius: 5px; margin-top:1px ;margin-bottom: 1px">
                <div class="chat-avatar" style="padding: 10px">
                  <a class="avatar" data-toggle="tooltip"  data-placement="left" title="" data-original-title="">
                    <img src="{{ asset('uploads/'.$resever->image) }}" alt="avatar"
                    />{{ $resever->name }}
                  </a>
                </div>
                <div class="chat-body" style="padding: 10px">
                  <div class="chat-content">
                    <p>{{ $item->message }}</p>
                    <span class="text-muted fs-7 mb-1">{{ $item->created_at->diffForHumans() }}</span>

                  </div>
               
                </div>
              </div>
              @endif
              @endforeach
              {{--<div class="chat chat-left">
                <div class="chat-avatar">
                  <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.png" alt="avatar"
                    />
                  </a>
                </div>
                <div class="chat-body">
                  <div class="chat-content">
                    <p>Hey John, I am looking for the best admin template.</p>
                    <p>Could you please help me to find it out?</p>
                  </div>
                  <div class="chat-content">
                    <p>It should be Bootstrap 4 compatible.</p>
                  </div>
                </div>
              </div>
              <div class="chat">
                <div class="chat-avatar">
                  <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                  data-original-title="">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"
                    />
                  </a>
                </div>
                <div class="chat-body">
                  <div class="chat-content">
                    <p>Absolutely!</p>
                  </div>
                  <div class="chat-content">
                    <p>Modern admin is the responsive bootstrap 4 admin template.</p>
                  </div>
                </div>
              </div>
              <p class="time">1 hours ago</p>
              <div class="chat chat-left">
                <div class="chat-avatar">
                  <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.png" alt="avatar"
                    />
                  </a>
                </div>
                <div class="chat-body">
                  <div class="chat-content">
                    <p>Looks clean and fresh UI.</p>
                  </div>
                  <div class="chat-content">
                    <p>It's perfect for my next project.</p>
                  </div>
                  <div class="chat-content">
                    <p>How can I purchase it?</p>
                  </div>
                </div>
              </div>
              <div class="chat">
                <div class="chat-avatar">
                  <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                  data-original-title="">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"
                    />
                  </a>
                </div>
                <div class="chat-body">
                  <div class="chat-content">
                    <p>Thanks, from ThemeForest.</p>
                  </div>
                </div>
              </div>
              <div class="chat chat-left">
                <div class="chat-avatar">
                  <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.png" alt="avatar"
                    />
                  </a>
                </div>
                <div class="chat-body">
                  <div class="chat-content">
                    <p>I will purchase it for sure.</p>
                  </div>
                  <div class="chat-content">
                    <p>Thanks.</p>
                  </div>
                </div>
              </div>
              <div class="chat">
                <div class="chat-avatar">
                  <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title=""
                  data-original-title="">
                    <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"
                    />
                  </a>
                </div>
                <div class="chat-body">
                  <div class="chat-content">
                    <p>Great, Feel free to get in touch on</p>
                  </div>
                  <div class="chat-content">
                    <p>https://pixinvent.ticksy.com/</p>
                  </div>
                </div>
              </div> --}}
            </div>
          </div>
        </section>
       
      </div>
    </div>
  </div>
@endsection



