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
                                <form id="sms_send_form" @keydown.enter.prevent>
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm-12 col-xl-12">
                                            <label for="SMSCellPhone" class="form-label">手機號碼：</label>
                                            <input type="text" class="form-control" id="SMSCellPhone" v-model="SMSCellPhone" data-rule-minlength="10" data-rule-maxlength="10" data-rule-required="true" data-rule-number="true" data-msg-required="手機號碼必填" data-msg-minlength="長度須為10" data-msg-maxlength="長度須為10" data-msg-number="請輸入數字">
                                        </div>
                                    </div>
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm-12 col-xl-12">
                                            <label for="SMSContent" class="form-label">發送內容：</label>
                                            <textarea class="form-control" id="SMSContent" v-model="SMSContent" rows="5" data-rule-required="true" data-msg-required="發送內容必填"></textarea>
                                            <div class="form-text"><?php echo $SMSPoint;?></div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-lg-auto">
                                            <button type="button" class="btn btn-success" @click="confirm_sms(SMSCellPhone, SMSContent)">預覽發送內容</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div v-if="SMS_Log_Items.length > 0" class="container-fluid pt-4 px-4">
                    <div class="bg-secondary text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">最近{{SMS_Log_Items.length}}筆發送紀錄</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-hover mb-0">
                                <thead>
                                    <tr class="text-white" style="white-space: nowrap;">
                                        <th scope="col">手機號碼</th>
                                        <th scope="col">發送內容</th>
                                        <th scope="col">發送結果</th>
                                        <th scope="col">發送日期</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="SMS_Log_Item in SMS_Log_Items" :key="Id">
                                        <td>{{ SMS_Log_Item.CellPhone }}</td>
                                        <td>{{ SMS_Log_Item.Content }}</td>
                                        <td>{{ SMS_Log_Item.Result }}</td>
                                        <td>{{ SMS_Log_Item.CreateTime }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <?php $this->load->view('template/footer', empty($footer_data)?null:$footer_data);?>

            </div>
            <!-- Content End -->

            <div class="modal fade" id="SMS_Preview_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">SMS Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-12 col-xl-4">
                                    <label for="text" class="form-label">手機號碼：</label>
                                </div>
                                <div class="col-sm-12 col-xl-8" id="CellPhone_Show"></div>
                            </div>
                            <div class="row g-4 mb-3">
                                <div class="col-sm-12 col-xl-12">
                                    <label for="text" class="form-label">發送內容：</label>
                                </div>
                                <div class="col-sm-12 col-xl-12">
                                    <pre id="Content_Show" style="background-color: #111; padding: 10px;"></pre>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" @click="send_sms()">確認發送</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <dialog id="Process_Info_Modal" style="background-color: #191C24; color: #FFF; border-color: #000; width: 80%; max-width: 250px;">
            <div class="d-flex align-items-center">
                <strong>Loading...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div>
        </dialog>

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
                const SMSCellPhone = ref('');
                const SMSContent = ref('');
                const confirm_sms = async (CellPhone, Content) => {
                    const formCheck = $('#sms_send_form').valid();
                    if (CellPhone == '' || Content == '' || CellPhone.length != 10 || !formCheck) {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        document.querySelector('#SMS_Preview_Modal').querySelector('.modal-body').querySelector('#CellPhone_Show').innerText = CellPhone;
                        document.querySelector('#SMS_Preview_Modal').querySelector('.modal-body').querySelector('#Content_Show').innerText = Content;
                        new bootstrap.Modal(document.getElementById('SMS_Preview_Modal')).show();
                    }
                };

                const send_sms = async () => {
                    bootstrap.Modal.getInstance(document.getElementById('SMS_Preview_Modal')).hide();
                    if (SMSCellPhone.value == '' || SMSContent.value == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        document.querySelector("#Process_Info_Modal").showModal();

                        let responseResult = null;
                        try {
                            let formData = new FormData();
                            formData.append('CellPhone', SMSCellPhone.value);
                            formData.append('Content', SMSContent.value);
                            let data = await fetch('<?php echo base_url()?>sms/send_sms/', {
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
                            document.querySelector('#Info_Modal').querySelector('.modal-body').innerHTML = '發送結果<br />' + responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Info_Modal')).show();
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                    }
                };

                return {
                    SMSCellPhone,
                    SMSContent,
                    confirm_sms,
                    send_sms
                };
            }

            
            const vue3Composition = {
                setup() {
                    const SMS_Log_Items = ref(<?php echo json_encode($SMS_Log_Items)?>);
                    const { SMSCellPhone, SMSContent, confirm_sms, send_sms } = SMS_Method();
                    
                    onBeforeMount( async () => {
                    });

                    return {
                        SMS_Log_Items,
                        SMSCellPhone,
                        SMSContent,
                        confirm_sms,
                        send_sms
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