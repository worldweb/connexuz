<!-- START SEND INVITATION MODAL POPUP -->
<div class="modal send-invitation-popup" id="SendInvite">
    <div class="modal-dialog">
        <!--  Loader  -->
        <div id="popUpLoader">
            <div class="widget-loader"><div class="load-dots"><span></span><span></span><span></span></div></div>
        </div>
        <!--  Loader  -->
        <div class="modal-content">
            <button type="button" class="close modal-close-btn-abs" data-dismiss="modal">&times;</button>
            <div class="modal-body">
                <div class="send-invitation-modal-content-wrap">
                    <div class="send-invitation-modal-text-content-wrap">
                        <h1 class="end-invitation-modal-title-text">Invite friends</h1>
                        <p class="send-invitation-modal-text-content">
                            Please enter the comma delimited email id's of the friends you would like to invite to become members of ConneXuz
                        </p>
                    </div>
                    <div class="send-invitation-form-wrap">
                        {{ html()->form('POST')->class('send-invitation-form')->id('invite-form')->open() }}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ html()->text('invite_email')
                                            ->class('form-control')
                                            ->placeholder('Email Address')
                                             }}
                                    </div>
                                    <div class="form-group">
                                        <button class="btn send-invitation-btn" type="submit">Send</button>
                                    </div>
                                </div>
                            </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SEND INVITATION MODAL POPUP -->
