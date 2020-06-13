inputFile = "input.test"




def parseReactions(lines):
	reactions = {}

	for reaction in lines:
		output, inputs = parseReaction(reaction)

		reactions[output] = inputs

	return reactions

def parseReaction(reaction):
	reactionIn, reactionOut = reaction.strip().split(" => ")
	
	outputQuantity, outputChemical = parseChemical(reactionOut)

	details = {}
	details["quantity"] = outputQuantity
	details["inputs"] = []

	inputs = reactionIn.split(",")

	for inputText in inputs:
		quantity, chemical = parseChemical(inputText.strip())
		details["inputs"].append((quantity, chemical))

	return (outputChemical, details)	


def parseChemical(text):
	quantity, chemical = text.split(" ")

	return (quantity, chemical)

with open(inputFile) as input:
	reactions = parseReactions(list(input))

# work backwards from FUEL

chemicalsNeeded = {}
