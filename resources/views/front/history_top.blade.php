  <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" onchange="history_page_load(this.value);">
                                    <option value="6" @if(front_class('ico_history')) selected @endif >Ico History</option>
                                    <option value="1" @if(front_class('deposit_history')) selected @endif>Deposit History</option>
                                    <option value="2" @if(front_class('transfer_history')) selected @endif >Fund Transfer History</option>
                                      <!-- <option value="3" @if(front_class('exchange_history')) selected @endif >Exchange History</option> -->
                                       {{--<option value="4" @if(front_class('trade_history')) selected @endif >Trade History</option>--}}
                                    {{--<option value="5" @if(front_class('swap_history')) selected @endif >Swap History</option>--}}


                                </select>
                            </div>
                                </div>