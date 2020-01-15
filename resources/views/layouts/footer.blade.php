<footer>
    <div class="footer">
        <div class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 mb-xs-3">
                        <h3>{{ __('About US') }}</h3>
                        @if(getAboutFooter())
                        {!! nl2br(getAboutFooter()) !!}
                        @endif
                    </div>
                    <div class="col-md-3 mb-xs-3">
                        <h3>{{ __('Contact US') }}</h3>
                        <p>
                            <div><i class="fa fa-phone"></i> {{ getPhone() }}</div>
                            <div><i class="fa fa-envelope"></i> {{ getEmail() }}</div>
                            <div><i class="fa fa-map-marker"></i> {{ getAddress() }}</div>
                        </p>
                    </div>
                    <div class="col-md-3 mb-xs-3">
                        <h3>{{ __('Social Networks') }}</h3>
                        <ul class="no-list">
                            <li>
                                @if(getFacebook())
                                <a target="_blank" href="{{ getFacebook() }}">
                                    <span class="fa fa-facebook-square"></span>
                                    Facebook
                                </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h3>{{ __('Useful Links') }}</h3>
                        <ul class="no-list">
                            <li><a href="{{ route('about',getLang()) }}">{{ __('About US') }}</a></li>
                            <li><a href="{{ route('contact',getLang()) }}">{{ __('Contact US') }}</a></li>
                            <li><a href="{{ route('term_condition',getLang()) }}">{{ __('Terms & Conditions') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="py-4 text-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        &copy; {!! __(':year Phsar24. All rights reserved.',['year'=>date('Y')]) !!}
                    </div>
                    <div class="col-md-5 text-right">
                        {{ __('Created By:') }} <a target="_blank" title="Panda Solution" class="created-by" href="http://www.panda-solution.net">Panda Solution</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<modal :show="showModal" @close="showModal = false"></modal>
