#!/usr/bin/env python


import sys
from subprocess import *
import json

#=============================================Functions

#read in source code from file and store it as a string
def readSourceCode(inputFileName):
	
	sourceCode = ""
	with open(inputFileName) as input:
		for line in input:
			
			sourceCode += line
	return sourceCode

def getFunctionName(str, returnType):
	
	leftParen = str.split("(")
	
	splitSpaces = leftParen[0].split(" ")
	
	return splitSpaces[len(splitSpaces)-1]

	#splitWithReturnType = str.split(returnType)[1]

	#functionName = splitWithReturnType.lstrip()

	#return functionName.split("(")[0]

def getParameterList(str):
	splitLeftParen = str.split("(")[1]
	functionParameters = splitLeftParen.split(")")[0]

	return functionParameters

def getParameterDictonary(str):
	splitLeftParen = str.split("(")[1]
	functionParameters = splitLeftParen.split(")")[0]

	splitCommaToParametersList = getParameterList(str).split(",")
	
	#print(splitCommaToParametersList)

	parametersDictionary = {}

	for params in splitCommaToParametersList:
		keyValueArray = params.lstrip().split(" ")
		if len(keyValueArray) > 1:
			key = keyValueArray[1]
			value = keyValueArray[0]
			parametersDictionary[key] = value
		else: 
			key = "none"
			value = ""
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


def generateJavaSourceCode(params, body, returnType, input, functionName):
	staticMethod = "public static " + returnType + " "+ functionName + "(" + params + ") {" + body + "}"

	mainSource = "public class Main { public static void main(String[] args) { System.out.print(" + functionName + "(" + input + ")); }" + staticMethod  + "}"

	return mainSource

def compileJava():
	call("ls", "-l")

def Main():

	
		
	args = sys.argv
	
	
	source = readSourceCode(args[1])


	returnType = args[2]
	
	inputValue = readSourceCode(args[3]);

	
	functionName = getFunctionName(source, returnType)
 	
	paramDict = getParameterDictonary(source)

	paramterList = str(getParameterList(source))

	methodBody = getMethodBody(source)

	mainSource = generateJavaSourceCode(paramterList, methodBody, returnType, inputValue, functionName)

	

	with open("Main.java", "w") as output:
		output.write(mainSource)

	
	try:
		returnValue = call(["javac", "Main.java"])
		if(returnValue != 0):
			raise Exception
		cmd = "java Main"
		p = Popen(cmd, shell=True, stdin=PIPE, stdout=PIPE, stderr=STDOUT, close_fds=True)
		returnResult = p.stdout.read()
		
		
		jsonList = [];
		paramDict["functionName"] = functionName
		paramDict["input"] = inputValue
		paramDict["output"] = returnResult.decode('ascii')
		
		jsonList.append(paramDict)
		print(json.dumps(jsonList));
		
		
	except:
		jsonList = [];
		paramDict["functionName"] = functionName
		paramDict["input"] = inputValue
		paramDict["output"] = "NO COMPILE"
		jsonList.append(paramDict)
		print(json.dumps(jsonList));

	
	
	#jsonList = [];
	#paramDict["functionName"] = functionName
	#paramDict["input"] = inputValue
	#paramDict["output"] = "NO COMPILE"
	#jsonList.append(paramDict)
	#print(json.dumps(jsonList));

	#print(str(json))

#=============================================Main


Main()
