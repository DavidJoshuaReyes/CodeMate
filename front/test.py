#!/usr/bin/env python


import sys
from subprocess import *
import json

#=============================================Functions

#read in source code from file and store it as a string
def readSourceCode(inputFileName):
    sourceCode = ""
    with open(inputFileName, "r") as input:
        for line in input:
            sourceCode = sourceCode + line
    return sourceCode

def getFunctionName(str, returnType):
    
    splitWithReturnType = str.split(returnType)[1]
    
    functionName = splitWithReturnType.lstrip()

    return functionName.split("(")[0]

def getParameterList(str):
    splitLeftParen = str.split("(")[1]
    functionParameters = splitLeftParen.split(")")[0]

    return functionParameters 

def getParameterDictonary(str):
    splitLeftParen = str.split("(")[1]
    functionParameters = splitLeftParen.split(")")[0]

    splitCommaToParametersList = getParameterList(str).split(",")
    
    parametersDictionary = {}
    
    for params in splitCommaToParametersList:
        keyValueArray = params.lstrip().split(" ")
        key = keyValueArray[1]
        value = keyValueArray[0]    
        parametersDictionary[key] = value
    
    return parametersDictionary 
    
    
def getMethodBody(str):
    leftCurlyIndex = str.find("{")
    leftCurlyRemoved = str[leftCurlyIndex+1:]

    reversedStr = reverseString(leftCurlyRemoved)

    rightCurlyIndex = reversedStr.find("}")
    rightCurlyRemoved = reversedStr[rightCurlyIndex+1:]

    return reverseString(rightCurlyRemoved)

def reverseString(str):
    return str[::-1]

    
def generateJavaSourceCode(params, body, returnType, input):
    staticMethod = "public static " + returnType + " run(" + params + ") {" + body + "}"

    mainSource = "public class Main { public static void main(String[] args) { System.out.print(run(" + input + ")); }" + staticMethod  + "}"

    return mainSource
    
def compileJava():
    call("ls", "-l")

def Main():


    args = sys.argv
    source = readSourceCode(args[1])

    returnType = args[2]

    inputValue = args[3]

    functionName = getFunctionName(source, "void")

    paramDict = getParameterDictonary(source)

    paramterList = str(getParameterList(source))

    methodBody = getMethodBody(source)

    mainSource = generateJavaSourceCode(paramterList, methodBody, returnType, inputValue)



    with open("Main.java", "w") as output:
        output.write(mainSource)

    call(["javac", "Main.java"])



    #returnResult = str(check_output(["java", "Main"]))[2:-3]

    cmd = "java Main"
    p = Popen(cmd, shell=True, stdin=PIPE, stdout=PIPE, stderr=STDOUT, close_fds=True)
    returnResult = p.stdout.read()    

    jsonList = [];
    paramDict["functionName"] = functionName
    paramDict["input"] = inputValue
    paramDict["output"] = returnResult
    jsonList.append(paramDict)
    #for key in paramDict.keys():
    #    json.append({key:paramDict[key]})



    print(json.dumps(jsonList));
    
    #print(str(json))

#=============================================Main


str1 = "public static void addTwo(int a, int b){return a+b;}"

print(getMethodBody(str1))



