<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		
	    <?php $this->load->view('template/head', empty($head_data)?null:$head_data);?>

	    <?php $this->load->view('template/head_script', empty($head_script_data)?null:$head_script_data);?>

        <style>
            #Bind_Static_IP_Info_Modal > .modal-dialog {
                max-width: auto;
            }
            @media (min-width: 576px){
                #Bind_Static_IP_Info_Modal > .modal-dialog {
                    max-width: 80%;
                }
            }
        </style>
	</head>
	<body>
        <div id="app" class="container-fluid position-relative d-flex p-0">
            
		    <?php $this->load->view('template/header', empty($header_data)?null:$header_data);?>
            
            <!-- Content Start -->
            <div class="content">
                
		        <?php $this->load->view('template/header_navbar', empty($header_data)?null:$header_data);?>
                
                <div class="d-flex justify-content-between mt-3 px-4 align-items-end">
                    <h2 style="font-weight: 500;">CM開通查詢</h5>
                    <div>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home me-2"></i>Home</a> / CM開通查詢
                    </div>
                </div>
                
                <div class="container-fluid pt-2 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-secondary rounded h-100 p-4">
                                <form @keydown.enter.prevent v-if="ISPItems.length > 0">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-xl-3">
                                            <label for="text" class="form-label">訂編(舊客編)</label>
                                        </div>
                                        <div class="col-sm-12 col-xl-4">
                                            <input type="text" class="form-control" v-model="custIdSearch" @keydown.enter="submit_query_cust(CMTSInfoItems)">
                                        </div>
                                        <div class="col-sm-12 col-lg-auto">
                                            <button type="button" class="btn btn-success" @click="submit_query_cust(CMTSInfoItems)">查詢</button>
                                        </div>
                                    </div>
                                </form>
                                <div v-else>
                                    資料載入中
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid pt-4 px-4">
                    <div class="bg-secondary rounded align-items-center p-4">

                        <div class="row mb-4">
                            <div class="col-12 col-md-3">
                                <div class="row">
                                    <div class="col-md-4">{{custIdType}}:</div>
                                    <div class="col-md-8">{{custId}}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-9 justify-content-start justify-content-md-end d-flex">
                                <div class="me-2">
                                    <button type="button" class="btn btn-secondary btn-sm" @click="restart_cm(custInfo.CMTS_Code, custInfo.CMMAC)">ReStart CM</button>
                                </div>
                                <div class="me-2">
                                    <button type="button" class="btn btn-secondary btn-sm" @click="show_CPE_Info(custInfo)">CPE</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 col-md-3">
                                <div class="row">
                                    <div class="col-md-4">CMTS:</div>
                                    <div class="col-md-8">{{custInfo.CMTS}} {{custInfo.CMTS_Status}}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-9">
                                <button type="button" class="btn btn-secondary btn-sm mb-2 me-2" :id="'btn_CMTS_' + CMTSInfoItem.Code" @click="query_MAC_Info_By_CMTS(CMTSInfoItem)" v-for="CMTSInfoItem in CMTSInfoItems" :key="Code">{{CMTSInfoItem.Code}}</button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="row">
                                    <div class="col-md-4">CMMAC:</div>
                                    <div class="col-md-8">{{custInfo.CMMAC}}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-9">
                                <div class="row">
                                    <div class="col-auto me-2 border">
                                        <button type="button" class="btn btn-secondary btn-sm m-2" @click="modify_cm_profile('query', custId, custInfo.CMMAC)">查詢(Query)</button>
                                    </div>
                                    <div class="col-auto me-2 border">
                                        <button type="button" class="btn btn-secondary btn-sm m-2 me-0" @click="modify_cm_profile('fix', custId, custInfo.CMMAC)">固定(fix)</button>
                                        <button type="button" class="btn btn-secondary btn-sm m-2 me-0" @click="modify_cm_profile('run', custId, custInfo.CMMAC)">綁定(run)</button>
                                        <button type="button" class="btn btn-secondary btn-sm m-2" @click="modify_cm_profile('nat', custId, custInfo.CMMAC)"><span style="color: lightcoral">取消(nat)</span></button>
                                    </div>
                                    <div class="col-auto me-2 border">
                                        <button type="button" class="btn btn-secondary btn-sm m-2 me-0" @click="modify_cm_profile('NATCC', custId, custInfo.CMMAC)">N是方</button>
                                        <button type="button" class="btn btn-secondary btn-sm m-2 me-0" @click="modify_cm_profile('NATFF', custId, custInfo.CMMAC)">N遠傳</button>
                                        <button type="button" class="btn btn-secondary btn-sm m-2" @click="modify_cm_profile('NATSS', custId, custInfo.CMMAC)">N宏遠</button>
                                    </div>
                                    <div class="col-auto me-2 border">
                                        <button type="button" class="btn btn-secondary btn-sm m-2 me-0" @click=show_bind_dialog()>綁定IP</button>
                                        <button type="button" class="btn btn-secondary btn-sm m-2 me-0" @click="query_bind_static_ip(custId)">查綁</button>
                                        <!-- <button type="button" class="btn btn-secondary btn-sm m-2" @click="unbind_static_ip(custId, custInfo.CMMAC)">解綁</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div v-if="custInfo.FixIPItems.length > 0" class="container-fluid pt-4 px-4">
                    <div class="bg-secondary text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">固定IP 共 {{custInfo.FixIPItems.length}} 筆</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-hover mb-0">
                                <thead>
                                    <tr class="text-white" style="white-space: nowrap;">
                                        <th scope="col">綁定日期</th>
                                        <th scope="col">綁定IP</th>
                                        <th scope="col">綁定MAC</th>
                                        <th scope="col">綁定設備</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="FixIPItem in custInfo.FixIPItems" :key="id">
                                        <td>{{ FixIPItem.createTime }}</td>
                                        <td>{{ FixIPItem.ip }}</td>
                                        <td>{{ FixIPItem.binding_mac }}</td>
                                        <td>{{ FixIPItem.device }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary mr-2" @click="unbind_static_ip(custId, FixIPItem.id, FixIPItem.ip, FixIPItem.binding_mac);">解綁IP</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div v-if="custInfo.logItems.length > 0" class="container-fluid pt-4 px-4">
                    <div class="bg-secondary text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">開通紀錄 共 {{custInfo.logItems.length}} 筆</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-hover mb-0">
                                <thead>
                                    <tr class="text-white" style="white-space: nowrap;">
                                        <th scope="col">日期時間</th>
                                        <th scope="col">動作</th>
                                        <th scope="col">工單</th>
                                        <th scope="col">CM</th>
                                        <th scope="col">舊CM</th>
                                        <th scope="col">CPNRMAC</th>
                                        <th scope="col">SCM</th>
                                        <th scope="col">結果</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="logItem in custInfo.logItems" :key="sn">
                                        <td>
                                            {{ logItem.date }}<br />
                                            {{ logItem.time }}
                                        </td>
                                        <td>{{ logItem.EC }}</td>
                                        <td>{{ logItem.AST }}</td>
                                        <td>{{ logItem.CM }}</td>
                                        <td>{{ logItem.OCM }}</td>
                                        <td>{{ logItem.CPNRMAC }}</td>
                                        <td>{{ logItem.SCM }}</td>
                                        <td>{{ logItem.result }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php $this->load->view('template/footer', empty($footer_data)?null:$footer_data);?>

            </div>
            <!-- Content End -->

            <dialog id="Process_Info_Modal" style="background-color: #191C24; color: #FFF; border-color: #000; width: 80%; max-width: 250px;">
                <div class="d-flex align-items-center">
                    <strong>Loading...</strong>
                    <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                </div>
            </dialog>

            <div class="modal fade" id="Processing_Modal" tabindex="-1" role="dialog" aria-labelledby="ProcessingModalLabel" aria-hidden="true" style="padding-top:15%">
                <div class="modal-dialog modal-m">
                    <div class="modal-content">
                        <div class="modal-header"><h3 style="margin:0;">Processing...</h3></div>
                        <div class="modal-body">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                            <!-- <div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="Device_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Device Info</h5>
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

            <div class="modal fade" id="CPE_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">CPE Info</h5>
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
            
            <div class="modal fade" id="CMTS_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%; min-with: 400px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">CMTS Info</h5>
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
            
            <div class="modal fade" id="Bind_Static_IP_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bind Static IP Info</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="bind_static_ip_form">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定IP</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="setReservationIP" data-rule-required="true" data-msg-required="綁定IP必填">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定設備MAC</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="setReservationMAC" data-rule-required="true" data-msg-required="綁定設備MAC必填">
                                    </div>
                                </div>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定設備名稱</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="setReservationDevice" placeholder="例：監視器、電腦" data-rule-required="true" data-msg-required="綁定設備名稱必填">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">連網設備</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <select class="form-select" name="UserDeviceType" id="UserDeviceType" v-model="SelectedUserDeviceType">
                                            <option value="一般CM">一般CM</option>
                                            <option value="高速CM">高速CM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">CMTS</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <select class="form-select" name="ParentDevice" id="ParentDevice" v-model="SelectedParentDevice">
                                            <option value="">請選擇</option>
                                            <option :value="CMTSInfoItem.Code" v-for="CMTSInfoItem in CMTSInfoItems" :key="Code">{{CMTSInfoItem.Code}} ({{CMTSInfoItem.Name_TW}})</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">ISP</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <select class="form-select" name="ISP" id="ISP" v-model="SelectedISP">
                                            <option :value="ISPItem.code" v-for="ISPItem in ISPItems" :key="code">{{ISPItem.name}}</button>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">原因：</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-10">
                                        <textarea class="form-control" id="ResReason" v-model="setReservationReason" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">設定者員編</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="EmployeeId" placeholder="例：A1234" data-rule-required="true" data-msg-required="設定者員編必填">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-sm-12 col-lg-12">
                                        <button type="button" class="btn btn-success" style="width: 100%;" @click="bind_static_ip(custId, setReservationIP, setReservationMAC)">進行綁定IP</button>
                                    </div>
                                </div>
                            </form>
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
            
        </div>


        <script src="<?php echo base_url()?>assets/js/vue.3.3.4.global.prod.js"></script>
        <!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->
        <script>
            const { createApp, ref, reactive, watch, onBeforeMount } = Vue

            const QueryTest = () => {
                const custIdSearch = ref('');
                const custId = ref('');
                const custIdType = ref('訂編')
                const custInfo = ref({
                    CMTS: '',
                    CMTS_Code: '',
                    CMTS_Status: '',
                    CMMAC: '',
                    logItems: [],
                    FixIPItems: [],
                    CPEInfoList: []
                });
                const CMTSInfoItems = ref([]);
                const ISPItems = ref([]);
                const setReservationIP = ref('');
                const setReservationMAC = ref('');
                const setReservationDevice = ref('');
                const setReservationReason = ref('');
                const SelectedUserDeviceType = ref('一般CM');
                const SelectedParentDevice = ref('');
                const SelectedISP = ref('');
                const EmployeeId = ref('');
                watch(custId, (newVal, oldVal) => {
                    if (newVal.length <= 8) {
                        custIdType.value = '訂編';
                    }
                    else {
                        custIdType.value = '舊客編';
                    }
                })
                watch(setReservationIP, async (newVal, oldVal) => {
                    if (newVal.split('.').length == 4) {
                        let responseResult = null;
                        let responseResultContent = '';
                        try {
                            let formData = new FormData();
                            formData.append( 'ip', setReservationIP.value );
                            let data = await fetch('http://nms.dctv.net.tw:8081/API/Query/IP_Mapping_ISP', {
                                method:"POST"
                                , body:formData
                            });
                            responseResultContent = await data.text();
                            // console.log(responseResultContent);
                            if(!data.ok) {
                                throw Error('fetch data 失敗');
                            }
                            responseResult = JSON.parse(responseResultContent);
                        } catch(error) {
                            console.log(responseResultContent + error);
                            // document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResultContent + error;
                            // new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            return;
                        }
                        
                        if (responseResult != null && responseResult.result == 1) {
                            // console.log(responseResult);
                            ISPItems.value.forEach(function (ISPItem) {
                                // console.log(ISPItem);
                                if(ISPItem.name == responseResult.items[0].ISPName) {
                                    SelectedISP.value = ISPItem.code;
                                }
                            });
                        }
                        else {
                            console.log(responseResult.msg);
                            // document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResult.msg;
                            // new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                    }
                })
                const submit_query_cust = async (CMTSInfoItems, ShowProcess = true) => { // 相当于 methods 里面的事件
                    custId.value = '';
                    custIdType.value = '訂編';
                    custInfo.value = {
                        CMTS: '',
                        CMTS_Code: '',
                        CMTS_Status: '',
                        CMMAC: '',
                        logItems: [],
                        FixIPItems: [],
                        CPEInfoList: []
                    };
                    setReservationIP.value = '';
                    setReservationMAC.value = '';
                    setReservationDevice.value = '';
                    setReservationReason.value = '';
                    SelectedUserDeviceType.value = '一般CM';
                    SelectedParentDevice.value = '';
                    SelectedISP.value = ISPItems.value[0]['code'];
                    EmployeeId.value = '';
                    if (custIdSearch.value == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的訂編/舊客編';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        if(ShowProcess){
                            // ProcessModal.show();
                            // document.querySelector("#Process_Info_Modal").showModal();
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                        }

                        let responseResult = null;
                        try {
                            let formData = new FormData();
                            formData.append( 'custId', custIdSearch.value );
                            let data = await fetch('<?php echo base_url()?>home/query_cust/', {
                                method:"POST"
                                , body:formData
                            });
                            // console.log(data.text());
                            if(!data.ok) {
                                throw Error('fetch data 失敗');
                            }
                            responseResult = await data.json();
                        } catch(error) {
                            // document.querySelector("#Process_Info_Modal").close();
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();

                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            throw Error(error);
                            return;
                        }
                        
                        if (responseResult != null && responseResult.result == 1) {
                            custId.value = custIdSearch.value;
                            custInfo.value = responseResult.data;

                            SelectedParentDevice.value = custInfo.value.CMTS;
                            
                            CMTSInfoItems.forEach(function (CMTSInfoItem) {
                                let btn_CMTS = document.querySelector('#btn_CMTS_' + CMTSInfoItem.Code);
                                btn_CMTS.style.removeProperty("color");
                                btn_CMTS.style.removeProperty("fontWeight");
                                if(custInfo.value.CMTS == CMTSInfoItem.Name_TW){
                                    btn_CMTS.style.color = 'deepskyblue';
                                    btn_CMTS.style.fontWeight = 'bold';
                                }
                            });
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }

                        
                        if(ShowProcess){
                            // ProcessModal.hide();
                            // document.querySelector("#Process_Info_Modal").close();
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                        }
                    }
                };

                const show_CPE_Info = (custInfo) => {
                    if (custInfo.CMMAC == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        // document.querySelector("#Process_Info_Modal").showModal();
                        new bootstrap.Modal(document.getElementById('Processing_Modal')).show();

                        let CPEInfoContent = '';
                        custInfo.CPEInfoList.forEach(function(CPEInfoItem){
                            CPEInfoContent += '<div class="row mb-2">';
                            CPEInfoContent += '<div class="col-4 col-md-2">MAC:</div>';
                            CPEInfoContent += '<div class="col-8 col-md-4">' + CPEInfoItem['MAC address'] + '</div>';
                            CPEInfoContent += '<div class="col-4 col-md-2">IP:</div>';
                            CPEInfoContent += '<div class="col-8 col-md-4">' + CPEInfoItem['IP address'] + '</div>';
                            CPEInfoContent += '</div>';
                        });

                        // document.querySelector("#Process_Info_Modal").close();
                        bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                        setTimeout(() => {
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                        }, 500);

                        setTimeout(() => {
                            document.querySelector('#CPE_Info_Modal').querySelector('.modal-body').innerHTML = CPEInfoContent;
                            new bootstrap.Modal(document.getElementById('CPE_Info_Modal')).show();
                        }, 700);
                        
                    }
                }

                return {
                    custIdSearch,
                    custId,
                    custIdType,
                    custInfo,
                    CMTSInfoItems,
                    ISPItems,
                    setReservationIP,
                    setReservationMAC,
                    setReservationDevice,
                    setReservationReason,
                    SelectedUserDeviceType,
                    SelectedParentDevice,
                    SelectedISP,
                    EmployeeId,
                    submit_query_cust,
                    show_CPE_Info
                };
            }

            
            const vue3Composition = {
                setup() { // 传说中的setup
                    // 使用上面的定义的“类”，分散setup内部的代码
                    const { custIdSearch, custId, custIdType, custInfo, 
                        CMTSInfoItems,
                        ISPItems,
                        setReservationIP,
                        setReservationMAC,
                        setReservationDevice,
                        setReservationReason,
                        SelectedUserDeviceType,
                        SelectedParentDevice,
                        SelectedISP,
                        EmployeeId, submit_query_cust, show_CPE_Info } = QueryTest()

                    const query_MAC_Info_By_CMTS_Result = ref('');
                    const query_MAC_Info_By_CMTS = async (Selected_CMTSInfoItem) => {
                        if (custInfo.value.CMMAC == '') {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else{
                            // document.querySelector("#Process_Info_Modal").showModal();
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                            
                            const selected_CMTS = Selected_CMTSInfoItem.Code;
                            
                            let responseResult = null;
                            try {
                                let formData = new FormData();
                                formData.append('CMTS', selected_CMTS);
                                formData.append('CMMAC', custInfo.value.CMMAC);
                                // console.log('11111');
                                let data = await fetch('<?php echo base_url()?>home/query_MAC_Info_By_CMTS/', {
                                    method:"POST"
                                    , body:formData
                                });
                                // console.log(data.text());
                                if(!data.ok) {
                                    throw Error('fetch data 失敗');
                                }
                                responseResult = await data.json();
                            } catch(error) {
                                // document.querySelector("#Process_Info_Modal").close();
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();

                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                throw Error(error);
                                return;
                            }

                            
                            // document.querySelector("#Process_Info_Modal").close();
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            
                            if (responseResult != null && responseResult.result == 1) {
                                query_MAC_Info_By_CMTS_Result.value = responseResult.msg;
                                document.querySelector('#CMTS_Info_Modal').querySelector('.modal-body').innerHTML = '<pre>' + query_MAC_Info_By_CMTS_Result.value + '</pre>';
                                new bootstrap.Modal(document.getElementById('CMTS_Info_Modal')).show();
                            }
                            else{
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            }
                        }
                    };
                    
                    const modify_cm_profile = async (Action, CustId, CMMAC) => {
                        if (Action == '' || CustId == '' || CMMAC == '') {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else{
                            // document.querySelector("#Process_Info_Modal").showModal();
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                            
                            let responseResult = null;
                            try {
                                let formData = new FormData();
                                formData.append('Act', Action);
                                formData.append('custId', CustId);
                                formData.append('CMMAC', CMMAC);
                                let data = await fetch('<?php echo base_url()?>home/modify_cm_profile/', {
                                    method:"POST"
                                    , body:formData
                                });
                                // console.log(data.text());
                                if(!data.ok) {
                                    throw Error('fetch data 失敗');
                                }
                                responseResult = await data.json();
                            } catch(error) {
                                // document.querySelector("#Process_Info_Modal").close();
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();

                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                throw Error(error);
                                return;
                            }
                            
                            // document.querySelector("#Process_Info_Modal").close();
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            
                            if (responseResult != null && responseResult.result == 1) {
                                document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = (Action == 'query' ? '查詢' : '變更') + '結果<br />' + responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                            }
                            else{
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            }
                        }
                    };
                    
                    const query_bind_static_ip = async (CustId) => {
                        if (CustId == '') {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else{
                            // document.querySelector("#Process_Info_Modal").showModal();
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                            
                            let responseResult = null;
                            try {
                                let formData = new FormData();
                                formData.append('custId', CustId);
                                let data = await fetch('<?php echo base_url()?>home/query_bind_static_ip/', {
                                    method:"POST"
                                    , body:formData
                                });
                                // console.log(data.text());
                                if(!data.ok) {
                                    throw Error('fetch data 失敗');
                                }
                                responseResult = await data.json();
                            } catch(error) {
                                // document.querySelector("#Process_Info_Modal").close();
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();

                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                throw Error(error);
                                return;
                            }
                            
                            // document.querySelector("#Process_Info_Modal").close();
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            
                            if (responseResult != null && responseResult.result == 1) {
                                document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '查詢結果<br />' + responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                            }
                            else{
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            }
                        }
                    };
                    
                    const unbind_static_ip = async (CustId, ObjId, ResIP, ResMAC) => {
                        if (CustId == '' || ObjId == '' || ResIP == '' || ResMAC == '') {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else{
                            if(confirm('是否確認進行固定IP解除綁定 (' + ResIP + ', ' + ResMAC + ')？')){
                                // document.querySelector("#Process_Info_Modal").showModal();
                                new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                                
                                let responseResult = null;
                                try {
                                    let formData = new FormData();
                                    formData.append('custId', CustId);
                                    formData.append('ResIP', ResIP);
                                    formData.append('ResMAC', ResMAC);
                                    let data = await fetch('<?php echo base_url()?>home/unbind_static_ip/', {
                                        method:"POST"
                                        , body:formData
                                    });
                                    // console.log(data.text());
                                    if(!data.ok) {
                                        throw Error('fetch data 失敗');
                                    }
                                    responseResult = await data.json();
                                } catch(error) {
                                    // document.querySelector("#Process_Info_Modal").close();
                                    await new Promise(resolve => setTimeout(resolve, 500));
                                    bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();

                                    document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                                    new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                    throw Error(error);
                                    return;
                                }
                                
                                // document.querySelector("#Process_Info_Modal").close();
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                                
                                if (responseResult != null && responseResult.result == 1) {
                                    document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '解綁結果<br />' + responseResult.msg;
                                    new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                                    submit_query_cust(CMTSInfoItems.value);

                                    // var NewFixIPItems = [];
                                    // for (let i = 0; i < custInfo.value.FixIPItems.length; i++){
                                    //     if(custInfo.value.FixIPItems[i]['id'] != ObjId){
                                    //         array_push(NewFixIPItems, custInfo.value.FixIPItems[i]);
                                    //     }
                                    // }
                                    // custInfo.value.FixIPItems = NewFixIPItems;
                                }
                                else{
                                    document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                    new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                }
                            }
                        }
                    };

                    const show_bind_dialog = () => {
                        if (custId.value == '') {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else {
                            let BindCheck = true;
                            if (custInfo.value.FixIPItems.length > 0) {
                                if (!confirm('已有' + custInfo.value.FixIPItems.length + '筆固定IP，請問是否繼續綁定，超過一筆需另外收費。')) {
                                    BindCheck = false;
                                }
                            }
                            if (BindCheck) {
                                document.querySelector('#Bind_Static_IP_Info_Modal').querySelector('input').value = '';
                                new bootstrap.Modal(document.getElementById('Bind_Static_IP_Info_Modal')).show();
                            }
                        }
                    }
                    
                    const bind_static_ip = async (CustId, ResIP, ResMAC) => {
                        const formCheck = $('#bind_static_ip_form').valid();
                        if (CustId == '' || ResIP == '' || ResMAC == '' || !formCheck) {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請確認您所填入的資料是否正確。';
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else{
                            if(confirm('是否確認進行固定IP綁定 (' + ResIP + ', ' + ResMAC + ')？')){
                                await new Promise(resolve => setTimeout(resolve, 300));
                                bootstrap.Modal.getInstance(document.getElementById('Bind_Static_IP_Info_Modal')).hide();
                                
                                // document.querySelector("#Process_Info_Modal").showModal();
                                new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                                
                                let responseResult = null;
                                try {
                                    let formData = new FormData();
                                    formData.append('custId', CustId);
                                    formData.append('ResIP', ResIP);
                                    formData.append('ResMAC', ResMAC);
                                    formData.append('ResDevice', setReservationDevice.value);
                                    formData.append('ResReason', setReservationReason.value);
                                    formData.append('UserDeviceType', SelectedUserDeviceType.value);
                                    formData.append('ParentDevice', SelectedParentDevice.value);
                                    formData.append('ISP', SelectedISP.value);
                                    formData.append('EmployeeId', EmployeeId.value);
                                    formData.append('Service', 'CM');
                                    let data = await fetch('<?php echo base_url()?>home/bind_static_ip/', {
                                        method:"POST"
                                        , body:formData
                                    });
                                    // console.log(data.text());
                                    if(!data.ok) {
                                        throw Error('fetch data 失敗');
                                    }
                                    responseResult = await data.json();
                                } catch(error) {
                                    // document.querySelector("#Process_Info_Modal").close();
                                    await new Promise(resolve => setTimeout(resolve, 500));
                                    bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                                    
                                    document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                                    new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                    throw Error(error);
                                    return;
                                }
                                
                                // document.querySelector("#Process_Info_Modal").close();
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                                
                                if (responseResult != null && responseResult.result == 1) {
                                    document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '綁定固定IP結果<br />' + responseResult.msg;
                                    new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                                    submit_query_cust(CMTSInfoItems.value);
                                }
                                else{
                                    document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                    new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                }
                            }
                        }
                    };

                    const restart_cm = async (CMTS, CMMAC) => {
                        if (CMTS == '' || CMMAC == '') {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊' + (CMTS == '' ? '，請確定所屬CMTS' : '');
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else{
                            // document.querySelector("#Process_Info_Modal").showModal();
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                            
                            let responseResult = null;
                            try {
                                let formData = new FormData();
                                formData.append('CMTS', CMTS);
                                formData.append('CMMAC', CMMAC);
                                let data = await fetch('<?php echo base_url()?>home/restart_cm/', {
                                    method:"POST"
                                    , body:formData
                                });
                                // console.log(data.text());
                                if(!data.ok) {
                                    throw Error('fetch data 失敗');
                                }
                                responseResult = await data.json();
                            } catch(error) {
                                // document.querySelector("#Process_Info_Modal").close();
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();

                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                throw Error(error);
                                return;
                            }
                            
                            // document.querySelector("#Process_Info_Modal").close();
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            
                            if (responseResult != null && responseResult.result == 1) {
                                document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '重啟結果<br />' + responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                            }
                            else{
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            }
                        }
                    }
                    


                    onBeforeMount( async () => {
                        let responseResult = null;
                        try {
                            let data = await fetch('<?php echo base_url()?>home/query_Init/');
                            // console.log(data.text());
                            if(!data.ok) {
                                throw Error('fetch data 失敗');
                            }
                            responseResult = await data.json();
                        } catch(error) {
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '取得初始資料失敗，請再次重新載入頁面。' + error;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            throw Error(error);
                            return;
                        }
                        if (responseResult != null && responseResult.result == 1) {
                            CMTSInfoItems.value = responseResult.data.CMTSInfoItems;
                            ISPItems.value = responseResult.data.ISPItems;
                            SelectedISP.value = ISPItems.value[0]['code'];
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '取得初始資料失敗，請再次重新載入頁面。' + responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                    });

                    return { // 返回给模板，否则模板访问不到。这里返回的是对象。
                        custIdSearch,
                        custId,
                        custIdType,
                        CMTSInfoItems,
                        ISPItems,
                        custInfo,
                        submit_query_cust,
                        show_CPE_Info,
                        query_MAC_Info_By_CMTS,
                        modify_cm_profile,
                        query_bind_static_ip,
                        unbind_static_ip,
                        show_bind_dialog,
                        setReservationIP,
                        setReservationMAC,
                        setReservationDevice,
                        setReservationReason,
                        SelectedUserDeviceType,
                        SelectedParentDevice,
                        SelectedISP,
                        EmployeeId,
                        bind_static_ip,
                        restart_cm,
                    }
                }
            }
            // 创建vue3的实例
            const app = Vue.createApp(vue3Composition).mount('#app') // 挂载Vue的app实例
            
            // const app = createApp({
            //     setup() {
                    
            //         // 使用 ref() 進行雙向綁定
            //         const message = ref('你好啊')
            //         const custId = ref('')
            //         const data = new URLSearchParams();
            //         data.append('custId', custId);
                    
            //         // 需要回傳值，才能在 HTML 使用
            //         return{
            //         message
            //         }
            //     }
            // });
            // submit_query_cust
            // app.mount('#app');
        </script>

        <?php $this->load->view('template/footer_script', empty($footer_data)?null:$footer_data);?>
        
        <script>
            // const ProcessModal = new bootstrap.Modal(document.getElementById('Process_Info_Modal'));
            $(function () {
                
            });
        </script>

	</body>
</html>