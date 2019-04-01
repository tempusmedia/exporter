
<div class="modal fade" id="addSite" tabindex="-1" role="dialog" aria-labelledby="addSiteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSiteLabel">Add site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('site.store') }}">

                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-5">
                            <label for="recipient-name" class="col-form-label">Site name:</label>
                            <input type="text" class="form-control" name="name">
                        </div>


                        <div class="form-group col-7">
                            <label for="recipient-name" class="col-form-label">Site URL:</label>
                            <input type="text" class="form-control" name="store_url"
                                   placeholder="https://example.com">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="recipient-name" class="col-form-label">Consumer key</label>
                            <input type="text" class="form-control" name="consumer_key">
                        </div>
                        <div class="form-group  col-6">
                            <label for="recipient-name" class="col-form-label">Consumer secret</label>
                            <input type="text" class="form-control" name="consumer_secret">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save site <i class="fa fa-fw fa-save"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade" id="howTo" tabindex="-1" role="dialog" aria-labelledby="addSiteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSiteLabel">Add site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col col-12">
                    <div class="woo-sc-box info   ">Technical documentation for the REST API <a
                                href="https://woocommerce.github.io/woocommerce-rest-api-docs/">can be found
                            here</a>.&nbsp;
                    </div>
                    <h3 id="section-1">Requirements</h3>
                    <p>WordPress permalinks must be enabled at:&nbsp;<strong>Settings &gt; Permalinks</strong>.</p>
                    <h3 id="section-2">Enable REST API</h3>

                    <img src="https://docs.woocommerce.com/wp-content/uploads/2014/02/legacyapi-enablerestapi.png"
                         class="img-fluid" alt="">

                    <p>To enable the REST API within WooCommerce, go to&nbsp;<strong>WooCommerce &gt; Settings &gt;
                            Advanced</strong>&nbsp;&gt;<strong> Legacy API</strong> and tick&nbsp;the <strong>Enable
                            REST API</strong> checkbox.<br>
                        <em>Note: REST API was found at&nbsp;<strong>WooCommerce &gt; Settings &gt; API </strong>prior
                            to WooCommerce 3.4</em>.</p>

                    <h2 id="section-3">Generate API keys</h2>
                    <p>The WooCommerce REST API works on a key system to control access. These keys are linked to
                        WordPress users on your website.</p>

                    <img src="https://docs.woocommerce.com/wp-content/uploads/2014/02/restapi-addkey.png"
                         class="img-fluid" alt="">


                    <p>To create or manage keys for a specific WordPress user:</p>
                    <ol>
                        <li>Go to:&nbsp;<strong>WooCommerce &gt; Settings &gt; Advanced &gt; REST API</strong>.<br>
                            <em>Note: Keys/Apps was found at&nbsp;<strong>WooCommerce &gt; Settings &gt; API &gt;
                                    Key/Apps&nbsp;</strong>prior to WooCommerce 3.4</em>.
                        </li>
                        <li>Select<strong> Add Key</strong>. You are taken to the <strong>Key Details</strong>
                            screen.<br>

                            <img src="https://docs.woocommerce.com/wp-content/uploads/2014/02/api-keydetails.png"
                                 class="img-fluid" alt="">

                        </li>
                        <li>Add a <strong>Description</strong>.</li>
                        <li>Select the <strong>User</strong> you would like to generate a key for in the&nbsp;dropdown.
                        </li>
                        <li>Select a&nbsp;level of access for this API key —&nbsp;<strong>Read</strong> access,
                            <strong>Write</strong>
                            access or <strong>Read/Write</strong> access.
                        </li>
                        <li>Select&nbsp;<strong>Generate API Key</strong>, and WooCommerce creates API keys for that
                            user.
                        </li>
                    </ol>
                    <p>&nbsp;</p>
                    <p>Now that keys have been generated, you should see&nbsp;<strong>Consumer Key</strong> and
                        <strong>Consumer
                            Secret </strong>keys, a QRCode, and a Revoke API Key&nbsp;button.</p>
                    <p>
                        <img src="https://docs.woocommerce.com/wp-content/uploads/2014/02/restapi-keygeneration.png"
                             class="img-fluid" alt="">
                    </p>
                    <p>The <strong>Consumer Key</strong> and <strong>Consumer Secret</strong> may be entered in the
                        application using the WooCommerce API, and the app should also request your URL.</p>
                    <div class="woo-sc-box info   ">Learn more about REST API at:&nbsp;<a
                                href="http://gerhardpotgieter.com/2014/02/10/woocommerce-rest-api-client-library/"
                                target="_blank" rel="noopener">WooCommerce REST API Client Library</a>.
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

