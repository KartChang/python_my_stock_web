<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		
	    <?php $this->load->view('template/head', empty($head_data)?null:$head_data);?>

	    <?php $this->load->view('template/head_script', empty($head_script_data)?null:$head_script_data);?>

	</head>
	<body>
        <div id="app" class="container-fluid position-relative d-flex p-0">
            
		    <?php $this->load->view('template/header', empty($header_data)?null:$header_data);?>

            <!-- Content Start -->
            <div class="content">
                
		        <?php $this->load->view('template/header_navbar', empty($header_data)?null:$header_data);?>

                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-secondary rounded h-100 p-4">
                                <form id="main_form" @keydown.enter.prevent>
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm-12 col-xl-12">
                                            <label for="SMSCellPhone" class="form-label">MAC號碼：</label>
                                            <input type="text" class="form-control" id="SMSCellPhone" v-model="MACAddress" data-rule-required="true" data-msg-required="MAC號碼必填" @keydown.enter="convert_mac(MACAddress)">
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-lg-auto">
                                            <button type="button" class="btn btn-success" @click="convert_mac(MACAddress)">查詢</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php $this->load->view('template/footer', empty($footer_data)?null:$footer_data);?>

            </div>
            <!-- Content End -->

        </div>

        <dialog id="Process_Info_Modal" style="background-color: #191C24; color: #FFF; border-color: #000; width: 80%; max-width: 250px;">
            <div class="d-flex align-items-center">
                <strong>Loading...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        </dialog>

        <div class="modal fade" id="MAC_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">MAC Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-xl-4">
                                <label for="text" class="form-label">CM MAC</label>
                            </div>
                            <div class="col-sm-12 col-xl-8" id="CMMAC"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-xl-4">
                                <label for="text" class="form-label">CM MAC for CMTS</label>
                            </div>
                            <div class="col-sm-12 col-xl-8" id="CMTS_CMMAC"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-xl-4">
                                <label for="text" class="form-label">CM MAC for CPNR</label>
                            </div>
                            <div class="col-sm-12 col-xl-8" id="CPNR_CMMAC"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="Error_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Error Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url()?>assets/js/vue.3.3.4.global.prod.js"></script>
        <!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->
        <script>
            const { createApp, ref, reactive, watch, onBeforeMount } = Vue

            const SMS_Method = () => {
                const MACAddress = ref('');

                const convert_mac = async (MACAddress) => {
                    const formCheck = $('#main_form').valid();
                    if (MACAddress == '' || !formCheck) {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        document.querySelector("#Process_Info_Modal").showModal();

                        let responseResult = null;
                        try {
                            let formData = new FormData();
                            formData.append('CMMAC', MACAddress);
                            let data = await fetch('<?php echo base_url()?>mac_tool/convert_mac/', {
                                method:"POST"
                                , body:formData
                            });
                            // console.log(data.text());
                            if(!data.ok) {
                                throw Error('fetch data 失敗');
                            }
                            responseResult = await data.json();
                        } catch(error) {
                            document.querySelector("#Process_Info_Modal").close();
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            throw Error(error);
                            return;
                        }
                        
                        // ProcessModal.hide();
                        document.querySelector("#Process_Info_Modal").close();
                        
                        if (responseResult != null && responseResult.result == 1) {
                            document.querySelector('#MAC_Info_Modal').querySelector('#CMMAC').innerText = responseResult.data.CMMAC;
                            document.querySelector('#MAC_Info_Modal').querySelector('#CMTS_CMMAC').innerText = responseResult.data.CMTS_CMMAC;
                            document.querySelector('#MAC_Info_Modal').querySelector('#CPNR_CMMAC').innerText = responseResult.data.CPNR_CMMAC;
                            new bootstrap.Modal(document.getElementById('MAC_Info_Modal')).show();
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                    }
                };

                return {
                    MACAddress,
                    convert_mac
                };
            }

            
            const vue3Composition = {
                setup() {
                    const { MACAddress, convert_mac } = SMS_Method();
                    
                    onBeforeMount( async () => {
                    });

                    return {
                        MACAddress,
                        convert_mac
                    }
                }
            }
            
            const app = Vue.createApp(vue3Composition).mount('#app')
        </script>

        <?php $this->load->view('template/footer_script', empty($footer_data)?null:$footer_data);?>
        
        <script>
            // var nowModal;
            $(function () {
                
            });
        </script>

	</body>
</html>