<footer>
    <div class="footer">
        <div class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h3>{{ _t('About US') }}</h3>
                        @if(getAboutFooter())
                        {!! nl2br(getAboutFooter()) !!}
                        @endif
                    </div>
                    <div class="col-md-3">
                        <h3>{{ _t('Contact US') }}</h3>
                        <p>
                            <div><i class="fa fa-phone"></i> {{ getPhone() }}</div>
                            <div><i class="fa fa-envelope"></i> {{ getEmail() }}</div>
                            <div><i class="fa fa-map-marker"></i> {{ getAddress() }}</div>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h3>{{ _t('Social Networks') }}</h3>
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
                        <h3>{{ _t('Useful Links') }}</h3>
                        <ul class="no-list">
                            <li><a href="{{ route('about') }}">{{ _t('About US') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ _t('Contact US') }}</a></li>
                            <li><a href="{{ route('term_condition') }}">{{ _t('Terms & Conditions') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="py-4 text-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        &copy; {!! _t('copy_right') !!} {{ date('Y') }}
                    </div>
                    <div class="col-md-5 text-right">
                        {{ _t('Created By:') }} <a target="_blank" title="Panda Solution" class="created-by" href="http://www.panda-solution.net">Panda Solution</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<modal :show="showModal" @close="showModal = false"></modal>
