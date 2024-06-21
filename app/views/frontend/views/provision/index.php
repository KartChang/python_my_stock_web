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
                
                <div class="d-flex justify-content-between mt-3 px-4 align-items-end">
                    <h2 style="font-weight: 500;">ONT簡易開通 <small>(<a href="?host=iNas&WorkSheet=A2022040006479&NodeNo=XZ02-0032-00">大山</a> / <a href="?host=NM3000&WorkSheet=A2022040006479&NodeNo=XZ02-0032-00">數碼</a>)</small></h5>
                    <div>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home me-2"></i>Home</a> / ONT簡易開通 / <?php echo $Host == 'iNas' ? '大山' : '數碼';?>
                    </div>
                </div>

                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-secondary rounded h-100 p-4">
                                <form id="main_form" @keydown.enter.prevent>
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="CustID" class="form-label">訂戶編號：</label>
                                            <input type="text" class="form-control" id="CustID" v-model="CustID" data-rule-required="true" data-msg-required="訂戶編號：" autocomplete="off">
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="ONTSN" class="form-label">ONT序號：</label>
                                            <input type="text" class="form-control" id="ONTSN" v-model="ONTSN" data-rule-required="true" data-msg-required="ONT序號必填" autocomplete="off">
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="AcceptSheet" class="form-label">工單編號：</label>
                                            <input type="text" class="form-control" id="AcceptSheet" v-model="AcceptSheet" data-rule-required="true" data-msg-required="工單編號必填" autocomplete="off">
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="EventCode" class="form-label">操作功能：</label>
                                            <select class="form-select" name="EventCode" id="EventCode" v-model="EventCode" data-rule-required="true" data-msg-required="操作功能必填">
                                                <option value="">請選擇</option>
                                                <option value="A01">開通</option>
                                                <option value="R01">重新開機</option>
                                                <option value="M01">改速率</option>
                                                <option value="C01">換機</option>
                                                <option value="S01">拆機</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="StartEndDateRange" class="form-label">使用日期(起)：</label>
                                            <Datepicker v-model="StartEndDateRange" name="StartEndDateRange" range multi-calendars required :enable-time-picker="false" :format="'yyyy/MM/dd'" :dark="true"></Datepicker>
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="ServiceCode" class="form-label">開通速率：</label>
                                            <select class="form-select" name="ServiceCode" id="ServiceCode" v-model="ServiceCode" data-rule-required="true" data-msg-required="開通速率必填">
                                                <option value="">請選擇</option>
                                                <option :value="OnuProfileItem.Code" v-for="OnuProfileItem in OnuProfileItems" :key="Code">{{OnuProfileItem.Name}}({{OnuProfileItem.ProfileName}})</option>
                                                <!-- <option value="6_2">6M / 2M</option>
                                                <option value="10_5">10M / 5M</option>
                                                <option value="12_5">12M / 5M</option>
                                                <option value="20_5">20M / 5M</option>
                                                <option value="30_10">30M / 10M</option>
                                                <option value="30_30">30M / 30M</option>
                                                <option value="60_20">60M / 20M</option>
                                                <option value="60_60">60M / 60M</option>
                                                <option value="100_30">100M / 30M</option>
                                                <option value="120_60">120M / 60M</option>
                                                <option value="150_30">150M / 30M</option>
                                                <option value="150_40">150M / 40M</option>
                                                <option value="150_120">150M / 120M</option>
                                                <option value="200_50">200M / 50M</option>
                                                <option value="200_100">200M / 100M</option>
                                                <option value="240_60">240M / 60M</option>
                                                <option value="250_50">250M / 50M</option>
                                                <option value="250_100">250M / 100M</option>
                                                <option value="300_100">300M / 100M</option>
                                                <option value="360_100">360M / 100M</option>
                                                <option value="360_120">360M / 120M</option>
                                                <option value="400_100">400M / 100M</option>
                                                <option value="500_100">500M / 100M</option>
                                                <option value="500_120">500M / 120M</option>
                                                <option value="900_120">900M / 120M</option>
                                                <option value="1000_100">1000M / 100M</option>
                                                <option value="1200_120">1200M / 120M</option> -->
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="NodeNo" class="form-label">光點編號：</label>
                                            <input type="text" class="form-control" id="NodeNo" v-model="NodeNo">
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="ClientIP" class="form-label">Client IP：</label>
                                            <div class="form-control" style="background-color: #000;"><?php echo $this->input->ip_address()?></div>
                                        </div>
                                        <div class="col-sm-6 col-xl-6">
                                            <label for="OldONTSN" class="form-label">原ONT序號(換機用)：</label>
                                            <input type="text" class="form-control" id="OldONTSN" v-model="OldONTSN" autocomplete="off">
                                        </div>
                                        <!-- <div class="col-sm-6 col-xl-6">
                                            <label for="EndDate" class="form-label">使用日期(起)：</label>
                                            <input type="text" class="form-control" id="StartDate" v-model="StartDate" data-rule-required="true" data-msg-required="使用日期(起)：" autocomplete="off">
                                        </div> -->
                                        <!-- <div class="col-sm-6 col-xl-6">
                                            <label for="EndDate" class="form-label">使用日期(迄)：</label>
                                            <input type="text" class="form-control" id="EndDate" v-model="EndDate" data-rule-required="true" data-msg-required="使用日期(迄)：" autocomplete="off">
                                        </div> -->
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-lg-auto">
                                            <button type="button" class="btn btn-success" @click="provision_ont()">執行</button>
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

        <link rel="stylesheet" href="https://unpkg.com/@vuepic/vue-datepicker@latest/dist/main.css">

        <script src="<?php echo base_url()?>assets/js/vue.3.3.4.global.prod.js"></script>
        <!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->
        <script src="https://unpkg.com/@vuepic/vue-datepicker@latest"></script>
        <script>
            const { createApp, ref, reactive, watch, onBeforeMount  } = Vue
//http://172.16.1.20:8989/gpon/ontProcess_Kart.php?EventCode=A01&AcceptSheet=A2022040006479&CustID=00000000&ONTSN=DSNW270745D0&ServiceCode=60_60&StartDate=20230413000000&EndDate=20250504090000&NodeNo=XZ02-0032-00
            const ONT_Method = () => {
                const OnuProfileItems = ref([]);
                const CustID = ref('');
                const ONTSN = ref('');
                const EventCode = ref('');
                const AcceptSheet = ref('<?php echo $WorkSheet;?>');
                const ServiceCode = ref('');
                const StartDate = ref('');
                const EndDate = ref('');
                const StartEndDateRange = ref('');
                const NodeNo = ref('<?php echo $NodeNo;?>');
                const OldONTSN = ref('');
                

                // const StartDate = new Date();
                // const EndDate = new Date(new Date().setDate(StartDate.getDate() + 7));
                // UseDateRange.value = [StartDate, EndDate];

                const provision_ont = async () => {
                    const formCheck = $('#main_form').valid();
                    if (CustID.value == '' || ONTSN.value == '' || EventCode.value == '' || AcceptSheet.value == '' || ServiceCode.value == '' || StartEndDateRange.value == '' || !formCheck) {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        if(EventCode.value == 'C01' && OldONTSN.value == ''){
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的換機資訊';
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                        else{
                            if(confirm('是否確認對 ONT (' + ONTSN.value + ') 執行「' + $('#EventCode option:selected').text() + '」操作？')){
                                document.querySelector("#Process_Info_Modal").showModal();

                                let responseResult = null;
                                let responseResultContent = '';
                                try {
                                    let formData = new FormData();
                                    formData.append('CustID', CustID.value);
                                    formData.append('ONTSN', ONTSN.value);
                                    formData.append('EventCode', EventCode.value);
                                    formData.append('AcceptSheet', AcceptSheet.value);
                                    formData.append('ServiceCode', ServiceCode.value);
                                    formData.append('StartDate', date2str(StartEndDateRange.value[0], 'yyyy/MM/dd'));
                                    formData.append('EndDate', date2str(StartEndDateRange.value[1], 'yyyy/MM/dd'));
                                    formData.append('NodeNo', NodeNo.value);
                                    formData.append('OldONTSN', OldONTSN.value);
                                    let data = await fetch('<?php echo base_url()?>provision/ont_device/', {
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
                                    var InfoHtml = '\
                                    <div class="row mb-3">\
                                        <div class="col-12 col-md-12" style="overflow: auto;"><pre>' + error.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\r\n/g, '<br />') + '</pre></div>\
                                    </div>';

                                    document.querySelector("#Process_Info_Modal").close();
                                    document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + InfoHtml;
                                    new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                    throw Error(error);
                                    return;
                                }
                                
                                // ProcessModal.hide();
                                document.querySelector("#Process_Info_Modal").close();
                                
                                if (responseResult != null && responseResult.result == 1) {
                                    var InfoHtml = '\
                                    <div class="row mb-3">\
                                        <div class="col-12 col-md-12" style="overflow: auto;"><pre>' + responseResult.msg.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\r\n/g, '<br />') + '</pre></div>\
                                    </div>';
                                    document.querySelector('#Info_Modal').querySelector('.modal-body').innerHTML = '執行結果<br />' + InfoHtml;
                                    new bootstrap.Modal(document.getElementById('Info_Modal')).show();
                                }
                                else{
                                    var InfoHtml = '\
                                    <div class="row mb-3">\
                                        <div class="col-12 col-md-12" style="overflow: auto;"><pre>' + responseResult.msg.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\r\n/g, '<br />') + '</pre></div>\
                                    </div>';
                                    document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗<br />' + InfoHtml;
                                    new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                }
                            }
                        }
                    }
                };

                return {
                    OnuProfileItems,
                    CustID,
                    ONTSN,
                    EventCode,
                    AcceptSheet,
                    ServiceCode,
                    StartDate,
                    EndDate,
                    StartEndDateRange,
                    NodeNo,
                    OldONTSN,
                    provision_ont
                };
            }

            
            const vue3Composition = {
                components: { Datepicker: VueDatePicker },
                setup() {
                    const { OnuProfileItems, CustID, ONTSN, EventCode, AcceptSheet, ServiceCode, StartDate, EndDate, StartEndDateRange, NodeNo, OldONTSN, provision_ont } = ONT_Method();
                    
                    onBeforeMount( async () => {
                        let responseResult = null;
                        try {
                            let formData = new FormData();
                            formData.append( 'host', '<?php echo $Host;?>' );
                            let data = await fetch('<?php echo base_url()?>provision/query_Init/', {
                                method:"POST"
                                , body:formData
                            });
                            // let data = await fetch('<?php echo base_url()?>provision/query_Init/');
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
                            var NewOnuProfileItems = [];
                            for (let i = 0; i < responseResult.data.OnuProfileItems.length; i++){
                                responseResult.data.OnuProfileItems[i]['Name'] = responseResult.data.OnuProfileItems[i]['Code'].replace('_', 'M /') + 'M';
                                NewOnuProfileItems.push(responseResult.data.OnuProfileItems[i]);
                            }
                            OnuProfileItems.value = NewOnuProfileItems;
                            // OnuProfileItems.value = responseResult.data.OnuProfileItems;
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '取得初始資料失敗，請再次重新載入頁面。' + responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                    });

                    return {
                        OnuProfileItems,
                        CustID,
                        ONTSN,
                        EventCode,
                        AcceptSheet,
                        ServiceCode,
                        StartDate,
                        EndDate,
                        StartEndDateRange,
                        NodeNo,
                        OldONTSN,
                        provision_ont
                    }
                }
            }

            const app = Vue.createApp(vue3Composition)
            // app.component('VueDatePicker', VueDatePicker )
            app.mount('#app')
        </script>

        <?php $this->load->view('template/footer_script', empty($footer_data)?null:$footer_data);?>
        
        <script>
            // var nowModal;
            $(function () {
                // $('.input-daterange').datepicker({
                //     format: "yyyy/mm/dd",
                //     clearBtn: true,
                //     language: "zh-TW"
                // });
                // $('#StartDate, #EndDate').datepicker({
                //     format: "yyyy/mm/dd",
                //     clearBtn: true,
                //     language: "zh-TW"
                // });
            });

            function date2str(x, y) {
                if (x == null){
                    return '';
                }
                else{
                    var z = {
                        M: x.getMonth() + 1,
                        d: x.getDate(),
                        h: x.getHours(),
                        m: x.getMinutes(),
                        s: x.getSeconds()
                    };
                    y = y.replace(/(M+|d+|h+|m+|s+)/g, function(v) {
                        return ((v.length > 1 ? "0" : "") + z[v.slice(-1)]).slice(-2)
                    });

                    return y.replace(/(y+)/g, function(v) {
                        return x.getFullYear().toString().slice(-v.length)
                    });
                }
            }
        </script>

	</body>
</html>