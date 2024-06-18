<form
    action="@if(!empty($ticketData->rating->id)){{route('customer.ticket.ticketRatingStore',['ratingId'=>$ticketData->rating->id])}} @else {{route('customer.ticket.ticketRatingStore')}} @endif"
    method="post" class="form-horizontal" enctype="multipart/form-data" data-handler="commonResponseForModal">
    @csrf
    <div class="modal fade bd-example-modal-lg" id="ticketReview" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="">
                    <div class="ticketReview-header">
                        <div class="d-flex align-content-center justify-content-between">
                            <h5 class="ticketReview-modal-title"
                                id="exampleModalLabel">{{__('Rate This Ticket Agent')}}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    </div>
                    <div class="ticketReview-modal-box">
                        <p class="ticketReview-massage">
                            {{__('To help the ticket agent, please leave a comment for your rating')}}
                        </p>
                        <div class="ticketReview-text-icon">
                            <h5 class="rating-your-text">{{__('Your rating')}}</h5>
                            <div class="rate">
                                <input
                                    @if( !empty($ticketData->rating->rating) && $ticketData->rating->rating==5) checked
                                    @endif type="radio" id="star5" name="rate" value="5"/>
                                <label for="star5" title="text">{{__("5 stars")}}</label>
                                <input
                                    @if( !empty($ticketData->rating->rating) && $ticketData->rating->rating==4) checked
                                    @endif type="radio" id="star4" name="rate" value="4"/>
                                <label for="star4" title="text">{{__("4 stars")}}</label>
                                <input
                                    @if( !empty($ticketData->rating->rating) && $ticketData->rating->rating==3) checked
                                    @endif type="radio" id="star3" name="rate" value="3"/>
                                <label for="star3" title="text">{{__("3 stars")}}</label>
                                <input
                                    @if( !empty($ticketData->rating->rating) && $ticketData->rating->rating==2) checked
                                    @endif type="radio" id="star2" name="rate" value="2"/>
                                <label for="star2" title="text">{{__("2 stars")}}</label>
                                <input
                                    @if( !empty($ticketData->rating->rating) && $ticketData->rating->rating==1) checked
                                    @endif type="radio" id="star1" name="rate" value="1"/>
                                <label for="star1" title="text">{{__("1 stars")}}</label>
                            </div>
                        </div>
                        <input type="hidden" name="target_ticket" id="target_ticket" value="{{$ticketData->id}}">
                        <input type="hidden" name="rating_category" id="rating_category" value="1">
                        <div class="ticketReview-comment">
                            <div class="ticketReview-comment-text">
                                <label for="comment"> <strong>{{__('Comments')}} </strong> ({{__('min')}}.
                                    30 {{__('characters')}})</label>
                            </div>
                            <textarea name="rating_comment" id="comment" cols="30" rows="10"
                                      placeholder="{{__('Please describe the reason for your rating to help the ticket agent')}} ">{{$ticketData->rating->comment??""}}</textarea>
                        </div>

                    </div>
                    <div class="ticketReview-footer ">
                        <button type="submit" data-bs-dismiss="modal" class="ticket-btu-com">{{__('Submit')}}</button>
                        <button type="button" class="ticket-btu-com close-ticket-modal" data-bs-dismiss="modal"
                                aria-label="Close">{{__("Close")}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</form>
<!--ticketReview modal area end -->
