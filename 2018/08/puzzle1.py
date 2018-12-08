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
		
def sumMetadata(node):
	metadata = sum(node['metadata'])
	metadata = metadata + sumChildMetaData(node['children'])

	return metadata


def sumChildMetaData(nodes):
	metadata = 0

	for node in nodes:
		metadata = metadata + sumMetadata(node)

	return metadata


inputFile = open('input')
numberList = inputFile.read().strip().split()

nodes = getNodes(numberList, 1)

print("The metadata checksum is " + str(sumMetadata(nodes[0])))