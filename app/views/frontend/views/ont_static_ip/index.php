<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		
	    <?php $this->load->view('template/head', empty($head_data)?null:$head_data);?>

	    <?php $this->load->view('template/head_script', empty($head_script_data)?null:$head_script_data);?>

        <style>
            #Bind_Static_IP_Info_Modal > .modal-dialog, #Direct_Bind_Static_IP_Info_Modal > .modal-dialog {
                max-width: auto;
            }
            @media (min-width: 576px){
                #Bind_Static_IP_Info_Modal > .modal-dialog, #Direct_Bind_Static_IP_Info_Modal > .modal-dialog {
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
                    <h2 style="font-weight: 500;">ONT綁固I</h5>
                    <div>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home me-2"></i>Home</a> / ONT綁固I
                    </div>
                </div>
                
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-secondary rounded h-100 p-4">
                                <form id="main_form" @keydown.enter.prevent v-if="BridgeVLANItems.length > 0 && DHCPVLANItems.length > 0">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-xl-3">
                                            <label for="text" class="form-label">訂編</label>
                                        </div>
                                        <div class="col-sm-12 col-xl-4">
                                            <input type="text" class="form-control" v-model="custIdSearch" @keydown.enter="submit_query_cust()">
                                        </div>
                                        <div class="col-sm-12 col-lg-auto">
                                            <button type="button" class="btn btn-success" @click="submit_query_cust()">查詢</button>
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
                
                <div class="bg-secondary card mt-4 mx-4">
                    <div class="card-header">
                    查詢訂編：{{custId}}
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6 col-lg-4">
                                <div class="row">
                                    <label class="col-4 col-form-label"><span style="vertical-align: inherit;">OLT IP:</span></label>
                                    <div class="col-8 col-form-label">
                                    {{custInfo.ONTInfo.NEIPAddress}} ({{custInfo.ONTInfo.Host}})
                                        <div class="d-none">
                                            {{custInfo.OLTModel}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="row">
                                    <label class="col-4 col-form-label"><span style="vertical-align: inherit;">HW MAC:</span></label>
                                    <div class="col-8 col-form-label">
                                    {{custInfo.ONTInfo.MAC}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="row">
                                    <label class="col-4 col-form-label"><span style="vertical-align: inherit;">ONT SN:</span></label>
                                    <div class="col-8 col-form-label">
                                    {{custInfo.ONTInfo.ONTSN}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 col-lg-4">
                                <div class="row">
                                    <label class="col-4 col-form-label"><span style="vertical-align: inherit;">Profile:</span></label>
                                    <div class="col-8 col-form-label">
                                    {{custInfo.ONTInfo.Profile}} {{custInfo.ONTInfo.Host=='NM3000'?'('+custInfo.ONTInfo.ChargeName+')':''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="row">
                                    <label class="col-6 col-form-label"><span style="vertical-align: inherit;">VLAN:</span></label>
                                    <div class="col-6 col-form-label">
                                    {{custInfo.ONTInfo.VLAN}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="row">
                                    <label class="col-6 col-form-label" ><span style="vertical-align: inherit;">Is Bridge:</span></label>
                                    <div class="col-6 col-form-label">
                                    {{custInfo.ONTInfo.IsBridge==null?'':(custInfo.ONTInfo.IsBridge=='1'?'是':'否')}}
                                    </div>
                                </div>
                            </div>
                            <!-- <div v-if="custInfo.ONTInfo.Host === 'NM3000'" class="col-md-6 col-lg-4">
                                <div class="row">
                                    <label class="col-4 col-form-label" ><span style="vertical-align: inherit;">Speed:</span></label>
                                    <div class="col-8 col-form-label">
                                    {{custInfo.ONTInfo.ChargeName}}
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                
                <div v-if="custInfo.FixIPItems.length > 0" class="container-fluid pt-4 px-4">
                    <div class="bg-secondary text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">已綁定固定IP 共 {{custInfo.FixIPItems.length}} 筆</h6>
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

                <div class="container-fluid pt-4 px-4">
                    <div class="bg-secondary text-center rounded p-4">
                        <div v-if="CPEItems !== undefined && Object.keys(CPEItems).length > 0" class="form-group row mb-4">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table text-start align-middle table-hover mb-0">
                                        <thead>
                                            <tr class="text-white" style="white-space: nowrap;">
                                                <th scope="col">#</th>
                                                <th scope="col">MAC</th>
                                                <th scope="col">IP</th>
                                                <th scope="col">Operate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(CPEItem, Key, Seq) in CPEItems" :key="Key">
                                                <td>{{ CPEItem.PortName }}</td>
                                                <td>{{ CPEItem.MAC }}</td>
                                                <td>{{ CPEItem.IP == '' ? CPEItem.IP_Error : CPEItem.IP }}</td>
                                                <td>
                                                    <button v-if="CPEItem.BindMAC == '' && CPEItem.IP != '' && custInfo.ONTInfo.IsBridge == '1'" type="button" class="btn btn-primary" @click="show_bind_dialog(Key, CPEItem.IP, CPEItem.MAC);">綁定IP</button>
                                                    <span v-else-if="CPEItem.BindMAC == '' && CPEItem.IP == '' && custInfo.ONTInfo.IsBridge == '1'">
                                                        <div v-if="CPEItem.IP_Error == '等待取得IP'">
                                                            <!--設備未取得IP-->
                                                            <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                                                        </div>
                                                        <button v-else type="button" class="btn btn-success" @click="query_cpe_ip_by_mac(Key);" :disabled="IsGetDeviceIP">取得IP</button>
                                                    </span>
                                                    <span v-else-if="CPEItem.BindMAC == '' && custInfo.ONTInfo.IsBridge != '1'">綁定前請先改為固I模式</span>
                                                    <span v-else>已綁定:{{ CPEItem.BindMAC }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: inherit; border: none; color: #fff">變更模式:</span>
                                    </div>
                                    <select class="form-select" name="vlan" id="vlan" v-model="SelectedBridgeVLAN">
                                        <option value="">請選擇</option>
                                        <option :value="BridgeVLANItem.VLAN" v-for="BridgeVLANItem in BridgeVLANItems" :key="Id">{{BridgeVLANItem.ISPName}}({{BridgeVLANItem.VLAN}})</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button v-if="custInfo.ONTInfo.IsBridge == '1'" type="button" class="btn btn-primary mr-2" @click="modify_ftth_profile(custInfo.ONTInfo.Host === 'iNas' ? custInfo.OLTDefaultVLAN : '1111', '0')" :disabled="custInfo.ONTInfo.IsStop==null || custInfo.ONTInfo.IsStop=='1' ? true : false">解除綁定固定IP</button>
                                        <button v-else type="button" class="btn btn-info mr-2" @click="modify_ftth_profile(SelectedBridgeVLAN, '1')" :disabled="custInfo.ONTInfo.IsStop==null || custInfo.ONTInfo.IsStop=='1' ? true : false">綁定固定IP</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: inherit; border: none; color: #fff">變更一般路由:</span>
                                    </div>
                                    <select class="form-select" name="dhcp_vlan" id="dhcp_vlan" v-model="SelectedDHCPVLAN">
                                        <option value="">請選擇</option>
                                        <option :value="DHCPVLANItem.VLAN" v-for="DHCPVLANItem in DHCPVLANItems" :key="Id">{{DHCPVLANItem.ISPName}}({{DHCPVLANItem.VLAN}})</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info mr-2" @click="modify_ftth_profile(SelectedDHCPVLAN, '0')" :disabled="custInfo.ONTInfo.IsStop==null || custInfo.ONTInfo.IsStop=='1' ? true : false">確認變更</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="text-align: left;">
                                <button type="button" class="btn btn-info" id="BtnShowCPE" @click="query_cpe()" :disabled="custInfo.ONTInfo.IsStop==null || custInfo.ONTInfo.IsStop=='1' ? true : false">CPE</button>
                                <button type="button" class="btn btn-info mx-2" @click="query_bind_static_ip()" :disabled="custInfo.ONTInfo.IsStop==null || custInfo.ONTInfo.IsStop=='1' ? true : false">查綁</button>
                                <!-- <button type="button" class="btn btn-info" id="BtnUnbindIP" @click="unbind_static_ip()">解綁</button> -->
                                <button type="button" class="btn btn-info mx-2" @click="show_direct_bind_dialog(Key);" :disabled="custInfo.ONTInfo.IsStop == null || custInfo.ONTInfo.IsStop == '1' || custInfo.ONTInfo.IsBridge != '1' ? true : false">直接設定固定IP</button>
                            </div>
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

            <div class="modal fade" id="MAC_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">MAC Info</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-12 col-xl-4">
                                    <label for="text" class="form-label">CM MAC</label>
                                </div>
                                <div class="col-sm-12 col-xl-8" id="CMMAC"></div>
                            </div>
                            <div class="row g-4 mb-3">
                                <div class="col-sm-12 col-xl-4">
                                    <label for="text" class="form-label">CM MAC for CMTS</label>
                                </div>
                                <div class="col-sm-12 col-xl-8" id="CMTS_CMMAC"></div>
                            </div>
                            <div class="row g-4 mb-3">
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
                                        {{ setReservationIP }}
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定設備MAC</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        {{ setReservationMAC }}
                                        <!-- <input type="text" class="form-control" v-model="setReservationMAC" readonly disabled> -->
                                    </div>
                                </div>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定設備名稱</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="setReservationDevice" placeholder="例：監視器、電腦" data-rule-required="true" data-msg-required="綁定設備名稱必填">
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

            <div class="modal fade" id="Direct_Bind_Static_IP_Info_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Direct Bind Static IP Info (使用此功能時，請確認客端設備已確實拿到實體IP)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="bind_static_ip_form">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定IP</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="setReservationIP" placeholder="請輸入綁定IP" data-rule-required="true" data-msg-required="綁定IP必填">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定設備MAC</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="setReservationMAC" placeholder="請輸入綁定設備MAC" data-rule-required="true" data-msg-required="綁定設備MAC必填">
                                    </div>
                                </div>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-12 col-md-4 col-xl-2">
                                        <label for="text" class="form-label">綁定設備名稱</label>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-xl-4">
                                        <input type="text" class="form-control" v-model="setReservationDevice" placeholder="例：監視器、電腦" data-rule-required="true" data-msg-required="綁定設備名稱必填">
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

        </div>

        <script src="<?php echo base_url()?>assets/js/vue.3.3.4.global.prod.js"></script>
        <!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> -->
        <script>
            const { createApp, ref, reactive, watch, onBeforeMount } = Vue

            const ONT_Method = () => {
                const custIdSearch = ref('');
                const custId = ref('');
                const custInfo = ref({
                    OLTModel: '',
                    OLTDefaultVLAN: '',
                    FixIPItems: [],
                    ONTInfo: {}
                });
                const BridgeVLANItems = ref([]);
                const DHCPVLANItems = ref([]);
                const SelectedBridgeVLAN = ref('');
                const SelectedDHCPVLAN = ref('');
                const CPEItems = ref({});
                const setReservationIP = ref('');
                const setReservationMAC = ref('');
                const setReservationDevice = ref('');
                const setReservationReason = ref('');
                const EmployeeId = ref('');
                const SelectedCPEItemId = ref('');
                const IsGetDeviceIP = ref(false);

                const submit_query_cust = async (ShowProcess = true) => { 
                    custId.value = '';
                    custInfo.value = {
                        OLTModel: '',
                        OLTDefaultVLAN: '',
                        FixIPItems: [],
                        ONTInfo: {}
                    };
                    CPEItems.value = {};
                    if (custIdSearch.value == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的訂編';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        if(ShowProcess){
                            // ProcessModal.show();
                            // document.querySelector("#Process_Info_Modal").showModal();
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                        }

                        let responseResult = null;
                        let responseResultContent = '';
                        try {
                            let formData = new FormData();
                            formData.append('custId', custIdSearch.value);
                            let data = await fetch('<?php echo base_url()?>ont_static_ip/query_cust/', {
                                method:"POST"
                                , body:formData
                            });
                            // console.log(data.text());
                            if(!data.ok) {
                                throw Error('fetch data 失敗');
                            }
                            responseResultContent = await data.text();
                            responseResult = JSON.parse(responseResultContent);
                            // responseResult = await data.json();
                        } catch(error) {
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResultContent + error;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            // throw Error(error);
                            return;
                        }
                        
                        if (responseResult != null && responseResult.result == 1) {
                            custId.value = custIdSearch.value;
                            custInfo.value = responseResult.data;
                            if (DHCPVLANItems.value.length > 0) {
                                DHCPVLANItems.value.forEach((DHCPVLANItem) => {
                                    if(DHCPVLANItem.VLAN == custInfo.value.ONTInfo.VLAN){
                                        SelectedDHCPVLAN.value = custInfo.value.ONTInfo.VLAN;
                                    }
                                });
                            }
                            if (BridgeVLANItems.value.length > 0) {
                                BridgeVLANItems.value.forEach((BridgeVLANItem) => {
                                    if(BridgeVLANItem.VLAN == custInfo.value.ONTInfo.VLAN){
                                        SelectedBridgeVLAN.value = custInfo.value.ONTInfo.VLAN;
                                    }
                                });
                            }

                            // console.log(custInfo.value.ONTInfo);
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
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

                const query_cpe = async (ShowProcess = true) => { 
                    CPEItems.value = {};
                    
                    if ((custInfo.value.ONTInfo.Host == 'iNas' && (custId.value == '' || custInfo.value.OLTModel == '')) || (custInfo.value.ONTInfo.Host == 'NM3000' && custId.value == '')) {
                    //if (custId.value == '' || custInfo.value.OLTModel == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請填入完整的訂編';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        if(ShowProcess){
                            // ProcessModal.show();
                            // document.querySelector("#Process_Info_Modal").showModal();
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                        }
                        
                        let responseResult = null;
                        let responseResultContent = '';

                        try {
                            let formData = new FormData();
                            formData.append('custId', custId.value);
                            formData.append('OLTModel', custInfo.value.OLTModel);
                            let data = await fetch('<?php echo base_url()?>ont_static_ip/query_cpe/', {
                                method:"POST"
                                , body:formData
                                , signal: AbortSignal.timeout(120 * 1000)
                            });
                            // console.log(data.text());
                            if(!data.ok) {
                                throw Error('fetch data 失敗');
                            }
                            responseResultContent = await data.text();
                            responseResult = JSON.parse(responseResultContent);
                        } catch(error) {
                            error = error == 'AbortError: The user aborted a request.' ? '超過執行時間，請重新執行。' : error;
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResultContent + error;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            // throw Error(error);
                            return;
                        }
                        
                        
                        if(ShowProcess){
                            // ProcessModal.hide();
                            // document.querySelector("#Process_Info_Modal").close();
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                        }
                        else{
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Device_Info_Modal')).hide();
                        }
                        
                        if (responseResult != null && responseResult.result == 1) {
                            // console.log(responseResult);
                            CPEItems.value = responseResult.data;
                            // console.log(CPEItems.value);
                            // console.log(Object.keys(CPEItems.value).length);
                            
                            document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = 'CPE MAC取得成功，請點擊相應設備MAC的「取得IP」按鈕後進行綁定。';
                            new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();

                            if(Object.keys(CPEItems.value).length > 0){
                                // Object.keys(CPEItems.value).forEach(async (key) => {
                                //     await query_cpe_ip_by_mac(key);
                                // });

                                // let CPEItemKeys = Object.keys(CPEItems.value);
                                // for (let i = 0; i < CPEItemKeys.length; i++){
                                //     await query_cpe_ip_by_mac(CPEItemKeys[i]);
                                // }
                            }

                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }

                    }
                };

                const query_cpe_ip_by_mac = async (CPEItems_Seq) => { 
                    // console.log(CPEItems_Seq);
                    // console.log(CPEItems.value[CPEItems_Seq]);
                    IsGetDeviceIP.value = true;

                    let responseResult = null;
                    let responseResultContent = '';
                    
                    CPEItems.value[CPEItems_Seq]['IP'] = '';
                    CPEItems.value[CPEItems_Seq]['IP_Error'] = '等待取得IP';
                    
                    try {
                        let formData = new FormData();
                        formData.append('custId', custId.value);
                        formData.append('CPE_MAC', CPEItems.value[CPEItems_Seq]['MAC']);
                        let data = await fetch('<?php echo base_url()?>ont_static_ip/query_cpe_ip_by_mac/', {
                            method:"POST"
                            , body:formData
                            , signal: AbortSignal.timeout(60 * 1000)
                        });
                        // console.log(data.text());
                        responseResultContent = await data.text();
                        if(!data.ok) {
                            throw Error('fetch data 失敗');
                        }
                        responseResult = JSON.parse(responseResultContent);
                        
                        if (responseResult != null && responseResult.result == 1) {
                            CPEItems.value[CPEItems_Seq]['IP'] = responseResult.data.IP;
                            CPEItems.value[CPEItems_Seq]['IP_Error'] = responseResult.data.IP_Error;
                            CPEItems.value[CPEItems_Seq]['BindMAC'] = responseResult.data.BindMAC;
                        }
                        else{
                            CPEItems.value[CPEItems_Seq]['IP_Error'] = responseResult.msg;
                        }
                    } catch(error) {
                        error = error == 'AbortError: The user aborted a request.' ? '超過執行時間，請重新執行。' : error + responseResultContent;
                    }
                    IsGetDeviceIP.value = false;
                };
                
                const modify_ftth_profile = async (VLAN, IsBridge) => {
                    if (custId.value == '' || VLAN == '' || IsBridge == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請確認您所輸入的資料是否完整';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        if(confirm('是否確認進行模式變更？')){
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                            
                            let responseResult = null;
                            try {
                                let ReqUrl = 'http://172.16.1.20:8989/gpon/ontProcess.php';
                                ReqUrl += '?EventCode=M01';
                                ReqUrl += '&AcceptSheet=_____BBMS';
                                ReqUrl += '&CustID=' + custId.value;
                                ReqUrl += '&ServiceCode=' + custInfo.value.ONTInfo.ServiceCode;
                                ReqUrl += '&ONTSN=' + custInfo.value.ONTInfo.ONTSN;
                                ReqUrl += '&StartDate=' + custInfo.value.ONTInfo.StartDateStr;
                                ReqUrl += '&EndDate=' + custInfo.value.ONTInfo.EndDateStr;
                                ReqUrl += '&VLAN=' + VLAN;
                                ReqUrl += '&IsBridge=' + IsBridge;
                                let data = await fetch(ReqUrl, {
                                    method:"GET"
                                });
                                // console.log(data.text());
                                if(!data.ok) {
                                    throw Error('fetch data 失敗');
                                }
                                // responseResult = await data.json();
                                responseResult = await data.text();
                            } catch(error) {
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                // throw Error(error);
                                return;
                            }
                            
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            
                            if (responseResult != null && responseResult == 'OK') {
                                SelectedBridgeVLAN.value = '';
                                SelectedDHCPVLAN.value = '';
                                submit_query_cust(false);
                                document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '模式變更成功' + (IsBridge == '1' ? '<br />請等待2-3分鐘後，再次重新取得CPE。' : '');
                                new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                            }
                            else{
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            }
                        }
                    }
                };
                    
                const query_bind_static_ip = async () => {
                    if (custId.value == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                        
                        let responseResult = null;
                        try {
                            let formData = new FormData();
                            formData.append('custId', custId.value);
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
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + error;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            // throw Error(error);
                            return;
                        }
                        
                        await new Promise(resolve => setTimeout(resolve, 500));
                        bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                        
                        if (responseResult != null && responseResult.result == 1) {
                            document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '查詢結果<br />' + responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show(0);
                        }

                    }
                };
                    
                const unbind_static_ip = async (CustId, ObjId, ResIP, ResMAC) => {
                    // if (custId.value == '' || custInfo.value.ONTInfo == {} || custInfo.value.ONTInfo.MAC == undefined) {
                    if (CustId == '' || ObjId == '' || ResIP == '' || ResMAC == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        if(confirm('是否確認進行固定IP解除綁定 (' + ResIP + ', ' + ResMAC + ')？')){
                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                            
                            let responseResult = null;
                            let responseResultContent = '';
                            try {
                                let formData = new FormData();
                                // formData.append('custId', custId.value);
                                // formData.append('CMMAC', custInfo.value.ONTInfo.MAC);
                                
                                formData.append('custId', CustId);
                                formData.append('ResIP', ResIP);
                                formData.append('ResMAC', ResMAC);
                                let data = await fetch('<?php echo base_url()?>home/unbind_static_ip/', {
                                    method:"POST"
                                    , body:formData
                                });
                                // console.log(data.text());
                                responseResultContent = await data.text();
                                if(!data.ok) {
                                    throw Error('fetch data 失敗');
                                }
                                // responseResult = await data.json();
                                responseResult = JSON.parse(responseResultContent);
                            } catch(error) {
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResultContent + error;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                // throw Error(error);
                                return;
                            }
                            
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            
                            if (responseResult != null && responseResult.result == 1) {
                                submit_query_cust(false);
                                document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '解綁結果<br />' + responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                            }
                            else{
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            }
                        }
                    }
                };

                const show_bind_dialog = (ObjId, ResIP, ResMAC) => {
                    setReservationIP.value = '';
                    setReservationMAC.value = '';
                    setReservationDevice.value = '';
                    setReservationReason.value = '';
                    EmployeeId.value = '';
                    SelectedCPEItemId.value = '';
                    if (custId.value == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        setReservationIP.value = ResIP;
                        setReservationMAC.value = ResMAC;
                        SelectedCPEItemId.value = ObjId;
                        document.querySelector('#Bind_Static_IP_Info_Modal').querySelector('input').value = '';
                        new bootstrap.Modal(document.getElementById('Bind_Static_IP_Info_Modal')).show();
                    }
                }

                const show_direct_bind_dialog = (ObjId) => {
                    setReservationIP.value = '';
                    setReservationMAC.value = '';
                    setReservationDevice.value = '';
                    setReservationReason.value = '';
                    EmployeeId.value = '';
                    SelectedCPEItemId.value = '';
                    if (custId.value == '') {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        SelectedCPEItemId.value = ObjId;
                        document.querySelector('#Direct_Bind_Static_IP_Info_Modal').querySelector('input').value = '';
                        new bootstrap.Modal(document.getElementById('Direct_Bind_Static_IP_Info_Modal')).show();
                    }
                }

                const bind_static_ip = async (CustId, ResIP, ResMAC) => {
                    const formCheck = $('#bind_static_ip_form').valid();
                    let BindCPEItemId = SelectedCPEItemId.value;
                    if (CustId == '' || ResIP == '' || ResMAC == '' || !formCheck) {
                        document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '請先查詢開通資訊';
                        new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                    }
                    else{
                        if(confirm('是否確認進行固定IP綁定 (' + ResIP + ', ' + ResMAC + ')？')){
                            await new Promise(resolve => setTimeout(resolve, 300));
                            if (bootstrap.Modal.getInstance(document.getElementById('Bind_Static_IP_Info_Modal')) != null) {
                                bootstrap.Modal.getInstance(document.getElementById('Bind_Static_IP_Info_Modal')).hide();
                            }
                            else if (bootstrap.Modal.getInstance(document.getElementById('Direct_Bind_Static_IP_Info_Modal')) != null) {
                                bootstrap.Modal.getInstance(document.getElementById('Direct_Bind_Static_IP_Info_Modal')).hide();
                            }

                            new bootstrap.Modal(document.getElementById('Processing_Modal')).show();
                            
                            let responseResult = null;
                            let responseResultContent = '';
                            try {
                                let formData = new FormData();
                                // formData.append('custId', custId.value);
                                // formData.append('ResIP', ResIP);
                                // formData.append('ResMAC', ResMAC);
                                // formData.append('Service', 'FTTH');
                                
                                formData.append('custId', CustId);
                                formData.append('ResIP', ResIP);
                                formData.append('ResMAC', ResMAC);
                                formData.append('ResDevice', setReservationDevice.value);
                                formData.append('ResReason', setReservationReason.value);
                                formData.append('UserDeviceType', 'ONT');
                                formData.append('ParentDevice', custInfo.value.ONTInfo.NEIPAddress);
                                formData.append('ISP', custInfo.value.ONTInfo.VLAN);
                                formData.append('EmployeeId', EmployeeId.value);
                                formData.append('Service', 'FTTH');
                                let data = await fetch('<?php echo base_url()?>home/bind_static_ip/', {
                                    method:"POST"
                                    , body:formData
                                });
                                // console.log(data.text());
                                responseResultContent = await data.text();
                                if(!data.ok) {
                                    throw Error('fetch data 失敗');
                                }
                                responseResult = JSON.parse(responseResultContent);
                            } catch(error) {
                                await new Promise(resolve => setTimeout(resolve, 500));
                                bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '操作失敗。' + responseResultContent + error;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                                return;
                            }
                            
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            
                            if (responseResult != null && responseResult.result == 1) {
                                // submit_query_cust(false);
                                if (CPEItems.value !== undefined && Object.keys(CPEItems.value).length > 0) {
                                    CPEItems.value[BindCPEItemId]['BindMAC'] = ResMAC;
                                }

                                custInfo.value.FixIPItems.push(responseResult.fixIPItem);
                                
                                document.querySelector('#Device_Info_Modal').querySelector('.modal-body').innerHTML = '綁定固定IP結果<br />' + responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Device_Info_Modal')).show();
                            }
                            else{
                                document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = responseResult.msg;
                                new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            }
                        }
                    }
                };

                return {
                    custIdSearch,
                    custId,
                    custInfo,
                    DHCPVLANItems, 
                    BridgeVLANItems, 
                    SelectedBridgeVLAN,
                    SelectedDHCPVLAN,
                    submit_query_cust,
                    query_cpe,
                    CPEItems,
                    setReservationIP,
                    setReservationMAC,
                    setReservationDevice,
                    setReservationReason,
                    EmployeeId,
                    SelectedCPEItemId,
                    IsGetDeviceIP,
                    query_cpe_ip_by_mac,
                    modify_ftth_profile,
                    query_bind_static_ip,
                    unbind_static_ip,
                    show_bind_dialog,
                    show_direct_bind_dialog,
                    bind_static_ip
                };
            }

            
            const vue3Composition = {
                setup() {
                    const { custIdSearch, custId, custInfo, DHCPVLANItems, BridgeVLANItems, SelectedBridgeVLAN, SelectedDHCPVLAN, submit_query_cust, query_cpe, CPEItems, setReservationIP, setReservationMAC, setReservationDevice, setReservationReason, EmployeeId, SelectedCPEItemId, IsGetDeviceIP, query_cpe_ip_by_mac, modify_ftth_profile, query_bind_static_ip, unbind_static_ip, show_bind_dialog, show_direct_bind_dialog, bind_static_ip } = ONT_Method();
                    
                    onBeforeMount( async () => {
                        let responseResult = null;
                        try {
                            let data = await fetch('<?php echo base_url()?>ont_static_ip/query_vlan/');
                            // console.log(data.text());
                            if(!data.ok) {
                                throw Error('fetch data 失敗');
                            }
                            responseResult = await data.json();
                        } catch(error) {
                            await new Promise(resolve => setTimeout(resolve, 500));
                            bootstrap.Modal.getInstance(document.getElementById('Processing_Modal')).hide();
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '取得VLAN資料失敗，請再次重新載入頁面。' + error;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                            // throw Error(error);
                            return;
                        }
                        if (responseResult != null && responseResult.result == 1) {
                            DHCPVLANItems.value = responseResult.data.DHCP_VLAN;
                            BridgeVLANItems.value = responseResult.data.Bridge_VLAN;
                        }
                        else{
                            document.querySelector('#Error_Info_Modal').querySelector('.modal-body').innerHTML = '取得VLAN資料失敗，請再次重新載入此頁。' + responseResult.msg;
                            new bootstrap.Modal(document.getElementById('Error_Info_Modal')).show();
                        }
                    });

                    return {
                        DHCPVLANItems,
                        BridgeVLANItems,
                        custIdSearch,
                        custId,
                        custInfo,
                        submit_query_cust,
                        query_cpe,
                        CPEItems,
                        setReservationIP,
                        setReservationMAC,
                        setReservationDevice,
                        setReservationReason,
                        EmployeeId,
                        SelectedCPEItemId,
                        IsGetDeviceIP,
                        query_cpe_ip_by_mac,
                        modify_ftth_profile,
                        query_bind_static_ip,
                        unbind_static_ip,
                        show_bind_dialog,
                        show_direct_bind_dialog,
                        bind_static_ip,
                        SelectedBridgeVLAN,
                        SelectedDHCPVLAN
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