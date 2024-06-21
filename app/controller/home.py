import os
import logging
import inspect
import json
import pandas 
import numpy 
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g,jsonify
from app import app
import app.controller as baseController
from app.model import baseMode
from app.view_models.Home_ViewModel import Home_ViewModel
from app.repository.my_stock.stockRepository import StockRepository

@app.route('/' + baseController.Get_Ctrl_Name(__file__), methods=['POST','GET'])
@app.route('/', methods=['POST','GET'])
def index_At_home():
    # print(inspect.stack()[0][3])
    model = Home_ViewModel()
    model.CtrlName = baseController.Get_Ctrl_Name(__file__)
    model.ActName = inspect.stack()[0][3]
    
    return render_template('frontend/home/index.html', model=model)

    link = 'https://openapi.twse.com.tw/v1/exchangeReport/STOCK_DAY_ALL'
    data = pandas.read_json(link)
    data = data.replace(numpy.nan, 0, regex=False)
    # data.columns = ['Code','Name','TradeVolume','TradeValue','OpeningPrice','HighestPrice','LowestPrice','ClosingPrice','Change','Transaction']
    FloatCols=['TradeVolume', 'TradeValue', 'OpeningPrice', 'HighestPrice' ,'LowestPrice', 'ClosingPrice', 'Change', 'Transaction']
    data[FloatCols] = data[FloatCols].apply(pandas.to_numeric, errors='coerce', axis=1)
    # print(data)
    # data = df_conv_col_type(df=data, 
    #                         cols=['TradeVolume', 'TradeValue', 'OpeningPrice', 'HighestPrice' ,'LowestPrice',
    #                             'ClosingPrice', 'Change', 'Transaction'],
    #                         to='float',
    #                         ignore=True)
    data['Change2'] = data['ClosingPrice'] - data['OpeningPrice']
    data['Change_Percentage'] = data['Change2'] / data['OpeningPrice']
    data = data.sort_values(by='Change_Percentage', ascending=False).head(10)
    # print(tuple(map(tuple, data.values)))
    return data.to_json()





    logging.error('session logged_in: ' + ('' if session.get('logged_in') == None else session.get('logged_in')))
    if not session.get('logged_in'):
        # abort(401)
        return redirect(url_for('in_At_log'))
    RowItems = StockRepository().Find(None)
    if len(RowItems) > 0:
        return json.dumps(RowItems, cls=baseMode.ComplexEncoder) + baseController.Get_Ctrl_Name(__file__)
    else:
        return 'No Data'
    return "Hello, MVC框架!" + os.path.splitext(os.path.basename(__file__))[0]




@app.route('/' + baseController.Get_Ctrl_Name(__file__) + '/get_top_10_change', methods=['POST','GET'])
def get_top_10_change_At_home():
    print('-------------------------------------------------' + inspect.stack()[0][3])
    CMS_QueryModel = baseMode.CMS_QueryModel()
    CMS_QueryModel.draw = request.values.get('draw', type=int)
    CMS_QueryModel.start = request.values.get('start', type=int)
    CMS_QueryModel.length = request.values.get('length', type=int)
    # CMS_QueryModel.order = request.values.get('order')
    # CMS_QueryModel.columns = request.values.get('columns')
    # print(json.dumps(CMS_QueryModel))
    # print(request.args)
    # print(request.values)
    # print(CMS_QueryModel.columns)
    # print(CMS_QueryModel.order)

    for key, value in request.values.items():
        if key.lower().find('columns') == 0:
            _columnNameArr = key.replace(']', '').split('[')
            if _columnNameArr[2] == 'name':
                # print('1111111------------' + 'columns[' + _columnNameArr[1] + '][name]')
                # print(request.values.get('columns[' + _columnNameArr[1] + '][name]'))
                # print('1111111------------' + 'order[' + _columnNameArr[1] + '][dir]')
                # print(request.values.get('order[' + _columnNameArr[1] + '][dir]'))
                CMS_QueryModel.columns.append({'name':value,'data':request.values.get('columns[' + _columnNameArr[1] + '][data]'),'searchable':request.values.get('columns[' + _columnNameArr[1] + '][searchable]'),'orderable':request.values.get('columns[' + _columnNameArr[1] + '][orderable]')})
        elif key.lower().find('order') == 0:
            _columnNameArr = key.replace(']', '').split('[')
            if _columnNameArr[2] == 'column':
                # print('1111111------------' + 'columns[' + value + '][name]')
                # print(request.values.get('columns[' + value + '][name]'))
                # print('1111111------------' + 'order[' + _columnNameArr[1] + '][dir]')
                # print(request.values.get('order[' + _columnNameArr[1] + '][dir]'))
                CMS_QueryModel.order['column'].append(request.values.get('columns[' + value + '][name]'))
                CMS_QueryModel.order['sort'].append(request.values.get('order[' + _columnNameArr[1] + '][dir]'))
                CMS_QueryModel.order['sort_asc'].append(True if request.values.get('order[' + _columnNameArr[1] + '][dir]') == 'asc' else False)
                # CMS_QueryModel.order.append({'column':request.values.get('columns[' + value + '][name]'),'dir':request.values.get('order[' + _columnNameArr[1] + '][dir]')})
                # print(CMS_QueryModel.order)
    # print(CMS_QueryModel)
    # print(CMS_QueryModel.columns)
    # print(CMS_QueryModel.order)

    link = 'https://openapi.twse.com.tw/v1/exchangeReport/STOCK_DAY_ALL'
    data = pandas.read_json(link)
    data = data.replace(numpy.nan, 0, regex=False)
    FloatCols=['TradeVolume', 'TradeValue', 'OpeningPrice', 'HighestPrice' ,'LowestPrice', 'ClosingPrice', 'Change', 'Transaction']
    data[FloatCols] = data[FloatCols].apply(pandas.to_numeric, errors='coerce', axis=1)
    data['Change2'] = data['ClosingPrice'] - data['OpeningPrice']
    data['Change_Percentage'] = numpy.round((data['Change2'] / data['OpeningPrice']) * 100, 2)
    data = data.sort_values(by=CMS_QueryModel.order['column'], ascending=CMS_QueryModel.order['sort_asc']).head(10)
    
    # data['Change_Percentage'] = data['Change_Percentage'].astype(str) + '%'
    # print(data.to_json(orient="records"))
    return jsonify(draw=CMS_QueryModel.draw,
                    recordsTotal=len(data),
                    recordsFiltered=len(data),
                    data=json.loads(data.to_json(orient="records")))












