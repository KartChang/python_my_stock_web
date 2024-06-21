import os

def Get_Ctrl_Name(filename) -> str:
    return os.path.splitext(os.path.basename(filename))[0]
    
def Get_Area_Name(filename) -> str:
    PathArr = os.path.dirname(os.path.abspath(os.path.dirname(filename))).split('\\')
    return PathArr[len(PathArr)-1]