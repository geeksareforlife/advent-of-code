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

input = 380621
target = input + 10

while len(recipes) < target:
	createRecipes(recipes, current)
	changeCurrent(recipes, current)

answer = ""

for i in range(target - 10, target):
	answer = answer + str(recipes[i])

print("The scores are: " + answer)