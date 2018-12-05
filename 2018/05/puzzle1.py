import re

def replaceCharacters(string):
	replacements = ['aA','bB','cC','dD','eE','fF','gG','hH','iI','jJ','kK','lL','mM','nN','oO','pP','qQ','rR','sS','tT','uU','vV','wW','xX','yY','zZ','Aa','Bb','Cc','Dd','Ee','Ff','Gg','Hh','Ii','Jj','Kk','Ll','Mm','Nn','Oo','Pp','Qq','Rr','Ss','Tt','Uu','Vv','Ww','Xx','Yy','Zz']

	for pattern in replacements:
		string = string.replace(pattern, '')

	return string

inputFile = open('input')
polymer = inputFile.read()

newLength = len(polymer)
oldLength = len(polymer) + 1

while newLength < oldLength:
	oldLength = newLength
	polymer = replaceCharacters(polymer)
	newLength = len(polymer)

print("The final polymer has " + str(len(polymer)) + " units")