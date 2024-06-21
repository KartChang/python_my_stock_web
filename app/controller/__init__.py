import os

def Get_Ctrl_Name(filename) -> str:
    return os.path.splitext(os.path.basename(filename))[0]