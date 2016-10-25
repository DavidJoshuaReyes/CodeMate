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

def checkLoop(strs):
    return strs.count("for") + strs.count("while")
    
def checkRecursion(functionName, strs):
    return strs.count(functionName)

def Main():
	args = sys.argv
	
	source = readSourceCode(args[1])

	returnType = args[2]
	
	condition = args[3];

	functionName = getFunctionName(source, returnType)

	if(condition == "loop"):
		print(checkLoop(source))
	else:
		print(checkRecursion(functionName, source))
            


	
#=============================================Main


Main()
