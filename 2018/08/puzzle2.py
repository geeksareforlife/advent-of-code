def getNodes(numberList, numNodes):
	nodes = []

	for i in range(numNodes):
		# pop the first and second items
		numChildren = int(numberList.pop(0))
		numMetadata = int(numberList.pop(0))
		node = {
			'children': getNodes(numberList, numChildren),
			'metadata': []
			}
		for j in range(numMetadata):
			node['metadata'].append(int(numberList.pop(0)))

		nodes.append(node)

	return nodes
		
def getNodeValue(node):
	numChildren = len(node['children'])
	if numChildren == 0:
		return sum(node['metadata'])
	else:
		value = 0
		for metadata in node['metadata']:
			index = metadata - 1
			if index < numChildren:
				value = value + getNodeValue(node['children'][index])
		return value


inputFile = open('input')
numberList = inputFile.read().strip().split()

nodes = getNodes(numberList, 1)

print("The value of the root node is " + str(getNodeValue(nodes[0])))