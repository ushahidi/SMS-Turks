# -*- coding: utf-8 -*-
import time
import gdata.spreadsheet.service
import feedparser
import re

SLEEP_TIME = 30
email = ''                                          # HEY! Fill this in
password = ''                                       # This too! (I don't think there's anonymous support)
spreadsheetID = 't79NeXOxMfzXm8bf8dL3XWA'         # From the spread sheet url
worksheetID = 'od6'                                # Sheet 1 always (?) has this id

# Connect to Google
gdataConnection = gdata.spreadsheet.service.SpreadsheetsService()
gdataConnection.email = email
gdataConnection.password = password
gdataConnection.source = 'iReport Cacher'
gdataConnection.ProgrammaticLogin()

# Read last time from file
try:
  f = open("time.txt", "r")
  lastTime = float(f.readline().strip())
  f.close()
except IOError:
  lastTime = 0

# Print last time (for debugging) and set lastSuccess
print "Last time is %d \n" % lastTime
lastSuccess = lastTime

# Loop forever
while 1:
  # Get rss
  feed = feedparser.parse("http://rss.ireport.com/feeds/latest.rss")
  added = 0             # Number of added entries
  feedTime = lastTime   # Last time in this feed download

  # Loop over all entries
  for post in feed['entries']:

    # Extract time
    postTime = post['updated_parsed']

    # Check about updating feed time
    if time.mktime(postTime) > feedTime:
      feedTime = time.mktime(postTime)
      # Save the time incase we quit
      f = open("time.txt", "w")
      f.write("%f" % feedTime)
      f.close()

    # Skip old entries
    if time.mktime(postTime) <= lastTime + 1:
      continue

    # If this is the first addition, report the elapsed time
    # (perhaps they only update the feed at some interval and we can stop hammering them)
    if added == 0:
      print "Time since previous addition: %d" % (time.mktime(postTime) - lastSuccess)
      lastSuccess = time.mktime(postTime)

    # Build Google Doc entry
    entry = {}
    entry['date'] = time.strftime("%Y-%m-%d %H:%M:%S", postTime)
    entry['title'] = post['title']
    entry['description'] = re.sub(r'<[^>]*?>', '', post['description']).replace("&nbsp;"," ")
    entry['image'] = post['enclosures'][0]['href'].replace("_sm.jpg", "_lg.jpg")

    # Add row to spreadsheet
    addedEntry = gdataConnection.InsertRow(entry, spreadsheetID, worksheetID)
    if isinstance(addedEntry, gdata.spreadsheet.SpreadsheetsList):
      added = added + 1
      print "New entry at %s [%s]" % (entry['date'], entry['title'])
    else:
      # Should probably quit, somebody f-ed up the spreadsheet
      print "Insert row failed!"

  # End of feed, report rows added (seems to be 12 every time)
  print "%d rows added" % added

  # Update last time value (time that indicates rows are not new)
  # (max may not be needed)
  lastTime = max(lastTime, feedTime)

  # Delay, don't hammer iReport too much...
  time.sleep(SLEEP_TIME)

