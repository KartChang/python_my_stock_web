
import datetime
from functools import wraps
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g,jsonify

def df_conv_col_type(df, cols, to, ignore=False):
    '''
    一次轉換多個欄位的dtype
    '''
    cols = conv_to_list(cols)
    for i in range(len(cols)):
        if ignore :
            try:
                df[cols[i]] = df[cols[i]].astype(to)
            except:
                df[cols[i]] = 0
                print('df_conv_col_type - ' + cols[i] + '轉換錯誤')
                continue
        else:
            df[cols[i]] = df[cols[i]].astype(to)
    return df

def conv_to_list(obj):
    '''
    將物件轉換為list
    '''
    if not isinstance(obj, list) :
        results = [obj]
    else:
        results = obj
    return results

# def check_cms_is_login(func):
    
#     def warp():
#         print('check_cms_is_login')
#         print("Now use function '{}'".format(func.__name__))
#         IsLogin = False
#         if 'CMS_User_Info' in session and session['CMS_User_Info'] != None and session['CMS_User_Info'] != '':
#         # if session != None:
#             print('sess----------------------')
#             func()
#         return redirect(url_for('in_At_log_At_cms'))
#     return warp

def cms_login_required(UserSessionKey, RedirectFuncName):
    def decorator(func):
        @wraps(func)
        def wrapped(*args, **kwargs):
            if UserSessionKey in session and session[UserSessionKey] != None and session[UserSessionKey] != '':
                return func(*args, **kwargs)
            return redirect(url_for(RedirectFuncName))
        return wrapped
    return decorator

    print('check_cms_is_login')
    IsLogin = False
    # if 'CMS_User_Info' in session and session['CMS_User_Info'] != None and session['CMS_User_Info'] != '':
    if session != None:
        IsLogin = True
        pass
    print('------------------------is_login:' + ('success' if IsLogin == True else 'fail'))
    # return True if IsLogin == True else redirect(url_for('in_At_log_At_cms'))
    return redirect(url_for('in_At_log_At_cms'))
    # return func()

def StringIsNullOrWhiteSpace(SourceStr:str=None):
    if SourceStr == None:
        return True
    if not SourceStr.strip():
        return True
    return False

def obj_dict(obj):
    if isinstance(obj, tuple):
        return {'__tuple__': True, 'items': list(obj)}
    elif isinstance(obj, list):
        return [obj_dict(item) for item in obj]
    elif isinstance(obj, dict):
        return {key: obj_dict(value) for key, value in obj.items()}
    elif isinstance(obj, datetime.datetime):
        return obj.strftime('%Y-%m-%d %H:%M:%S')
    elif isinstance(obj, datetime.date):
        return obj.strftime('%Y-%m-%d')
    else:
        return obj.__dict__