def createRecipes(recipes, current):
	sum = 0
	for recipe in current:
		sum = sum + recipes[recipe]

	if sum > 9:
		recipes.append(sum // 10)
		recipes.append(sum - 10)
	else:
		recipes.append(sum)

def changeCurrent(recipes, current):
	for i in range(len(current)):
		current[i] = (current[i] + (1 + recipes[current[i]])) % len(recipes)

##### START MAIN #####
recipes = [3, 7]
current = [0, 1]

target = "380621"
found = False
location = 0

while found == False:
	for i in range(10000000):
		createRecipes(recipes, current)
		changeCurrent(recipes, current)
	print(len(recipes))
	allRecipes = ''.join(str(x) for x in recipes)
	location = allRecipes.find(target)
	if location > -1:
		found = True

print("Found after " + str(location) + " recipes")