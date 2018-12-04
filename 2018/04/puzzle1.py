import re
from collections import OrderedDict

with open('input') as input:
	entries = list(input)

unsortedLog = {}

for entry in entries:
	match = re.search('\[(?P<datetime>[0-9\-\:\s]+)\] (?P<log>.*)', entry.strip())
	if match == None:
		print("Entry not matched: " + entry)
	else:
		if match['datetime'] in unsortedLog:
			raise Exception("Datetime " + datetime + " already seen")

		unsortedLog[match['datetime']] = match['log']

# sort the log
sortedLog = OrderedDict(sorted(unsortedLog.items(), key=lambda unsortedLog: unsortedLog[0]))

guards = {}

currentGuard = 0
fellAsleep = 0
for datetime,log in sortedLog.items():
	match = re.search('Guard #(?P<guard>\d+) begins shift', log)
	if match == None:
		match = re.search('\d{4}-\d{2}-\d{2} \d{2}\:(?P<minute>\d{2})', datetime)
		if match == None:
			print("DateTime not matched: " + datetime)
		else:
			minute = int(match['minute'])
			if log == "falls asleep":
				fellAsleep = minute
			elif log == "wakes up":
				for i in range(fellAsleep, minute):
					guards[currentGuard][i] += 1

	else:
		# set the current guard
		currentGuard = match['guard']
		if currentGuard not in guards:
			guards[currentGuard] = {key: 0 for key in list(range(60))}

maxTotal = 0
maxMinute = 0
maxGuard = 0
for guard in guards:
	total = sum(guards[guard].values())
	if total > maxTotal:
		maxTotal = total
		maxGuard = guard
		maxMinute = max(guards[guard], key=guards[guard].get)

print("Guard #" + str(maxGuard) + " spent " + str(maxTotal) + " asleep. Answer is " + str(int(maxGuard) * maxMinute))


