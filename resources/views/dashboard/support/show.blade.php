@extends('dashboard.layout')
@section('title')Amyal l Support @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')

        <div id="app" class="dash-pages support clearfix">
            <div class="col-md-6 col-sm-6 col-xs-12  p-l-0">
                <h1>Support</h1>
                @if($ticket->status != 'Closed')
                    @if(auth()->user()->hasRole('supports.edit'))
                        <a href="{{route('supports.edit',$ticket->id)}}" class="btn btn-org change-status" style="width: 50%; @if($ticket->status == 'Closed') display: none; @endif">Close</a>
                    @endif
                @else
                    <p><strong>Closed</strong></p>
                @endif
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 p-0">
                <div class="pull-right">
                    <h3 class="orang m-b-0 m-t-10 p_18 ">Ticket NUmber: <strong class="gry">{{$ticket->reference_number}}</strong></h3>
                    <h3 class="orang m-t-10 p_18 ">Client: <strong class="gry">{{$ticket->user->company_name}}</strong></h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="add-data" style="display: none"  class="chat-box clearfix"  >
                <div v-for="message in messages">
                    <div v-if="message.sender_type === 'Client'" class="message-box right-img" >
                        <div class="message">
                            <p v-if="message.message != null">@{{message.message}}</p>
                            <p v-if="message.message != null">@{{message.created_at}}</p>
                            <span v-if="message.attachment != null "><a v-bind:href="'{{asset('storage/support/')}}'+ message.attachment" download class="btn btn-org nw-dwnld"><i class="fa fa-download"></i> Download</a></span>
                        </div>
                    </div>
                    <div v-else-if="message.sender_type === 'Agent'" class="message-box left-img" >
                        <div class="message">
                            <p v-if="message.message != null">@{{message.message}}</p>
                            <p v-if="message.message != null">@{{message.created_at}}</p>
                            <span v-if="message.attachment != null "><a v-bind:href="'{{asset('storage/support/')}}'+ message.attachment" download class="btn btn-org nw-dwnld"><i class="fa fa-download"></i> Download</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            @if($ticket->status != 'Closed')
                <div class="enter-message">
                    <input maxlength="10000" v-model="messageBox" type="text" name="message" class="msg" placeholder="Enter your message.."/>
                    @if(auth()->user()->hasRole('supports.update'))
                        <button style="height: 78px;" type="submit" class="btn btn-org pull-right nw-pad " @click.prevent="postMessage">Send</button>
                    @endif
                    {{--<div class="file-upload1 mynwup">--}}
                    {{--<label style="padding:2px 28px" for="upload" class="file-upload__label btn btn-gry nw-pad "><i class="fa fa-paperclip"></i> Attach</label>--}}
                    {{--<input id="upload" accept=".png, .jpg, .jpeg, .pdf"  class="file-upload__input" type="file" name="file_upload1">--}}
                    {{--</div>--}}
                </div>
            @else
                <div class="enter-message">
                    <input disabled maxlength="10000" type="text" name="message" class="msg" placeholder="Enter your message.."/>
                        <button disabled style="height: 78px;" type="submit" class="btn btn-org pull-right nw-pad " @click.prevent="postMessage">Send</button>
                    {{--<div class="file-upload1 mynwup">--}}
                    {{--<label style="padding:2px 28px" for="upload" class="file-upload__label btn btn-gry nw-pad "><i class="fa fa-paperclip"></i> Attach</label>--}}
                    {{--<input id="upload" accept=".png, .jpg, .jpeg, .pdf"  class="file-upload__input" type="file" name="file_upload1">--}}
                    {{--</div>--}}
                </div>
            @endif
        </div>
@endsection


@section('js')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>

        window.onload = function () {

            const app = new Vue({
                el: '#app',
                data:{
                    messages:{},
                    messageBox:'',
                    ticket:{!! $ticket->toJson() !!},
                    user:{!! auth()->check() ? auth()->user()->toJson() : 'null' !!}
                },
                mounted(){
                    this.getMessages();
                    this.listen()
                },
                methods:{
                    getMessages(){
                        axios.get('{!! route('supports.getMessages',$ticket->id) !!}')
                            .then((response) => {
                            this.messages = response.data;
                    })
                    .catch(function (error) {
                            console.log(error);
                        });
                    },
                    postMessage(){
                        this.messages.push({
                            'message':this.messageBox,
                            'sender_type':'Agent',
                            'attachment':null
                        });
                        temp = this.messageBox;
                        this.messageBox = '';
                        axios.post('{!! route('supports.sendMessages',$ticket->id) !!}',{
                            'message': temp
                        })
                        .then((response) => {
//                            this.messages.push(response.data);
//                        this.messageBox = '';
                    })
                    .catch(function (error) {
                            console.log(error);
                        });
                    },
                    listen(){
                        Echo.channel('tickets.'+this.ticket.id)
                            .listen('NewMessage', (message) => {
                            this.messages.push(message);
//                            console.log(message);
                    })
                    }
                }
            })

            $( "#add-data" ).show( "fast" );

        };



    </script>
@endsection
