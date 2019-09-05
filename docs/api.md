## Table of contents

- [\AlecRabbit\Spinner\SnakeSpinner](#class-alecrabbitspinnersnakespinner)
- [\AlecRabbit\Spinner\PercentSpinner](#class-alecrabbitspinnerpercentspinner)
- [\AlecRabbit\Spinner\ClockSpinner](#class-alecrabbitspinnerclockspinner)
- [\AlecRabbit\Spinner\BlockSpinner](#class-alecrabbitspinnerblockspinner)
- [\AlecRabbit\Spinner\DiceSpinner](#class-alecrabbitspinnerdicespinner)
- [\AlecRabbit\Spinner\WeatherSpinner](#class-alecrabbitspinnerweatherspinner)
- [\AlecRabbit\Spinner\DotSpinner](#class-alecrabbitspinnerdotspinner)
- [\AlecRabbit\Spinner\MoonSpinner](#class-alecrabbitspinnermoonspinner)
- [\AlecRabbit\Spinner\BallSpinner](#class-alecrabbitspinnerballspinner)
- [\AlecRabbit\Spinner\EarthSpinner](#class-alecrabbitspinnerearthspinner)
- [\AlecRabbit\Spinner\SimpleSpinner](#class-alecrabbitspinnersimplespinner)
- [\AlecRabbit\Spinner\ArrowSpinner](#class-alecrabbitspinnerarrowspinner)
- [\AlecRabbit\Spinner\SectorsSpinner](#class-alecrabbitspinnersectorsspinner)
- [\AlecRabbit\Spinner\CircleSpinner](#class-alecrabbitspinnercirclespinner)
- [\AlecRabbit\Spinner\BouncingBarSpinner](#class-alecrabbitspinnerbouncingbarspinner)
- [\AlecRabbit\Spinner\TimeSpinner](#class-alecrabbitspinnertimespinner)
- [\AlecRabbit\Spinner\Core\Strip](#class-alecrabbitspinnercorestrip)
- [\AlecRabbit\Spinner\Core\Sentinel](#class-alecrabbitspinnercoresentinel)
- [\AlecRabbit\Spinner\Core\Spinner (abstract)](#class-alecrabbitspinnercorespinner-abstract)
- [\AlecRabbit\Spinner\Core\SpinnerCore (abstract)](#class-alecrabbitspinnercorespinnercore-abstract)
- [\AlecRabbit\Spinner\Core\Calculator](#class-alecrabbitspinnercorecalculator)
- [\AlecRabbit\Spinner\Core\Adapters\SymfonyOutputAdapter](#class-alecrabbitspinnercoreadapterssymfonyoutputadapter)
- [\AlecRabbit\Spinner\Core\Adapters\EchoOutputAdapter](#class-alecrabbitspinnercoreadaptersechooutputadapter)
- [\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)
- [\AlecRabbit\Spinner\Core\Coloring\Colors](#class-alecrabbitspinnercorecoloringcolors)
- [\AlecRabbit\Spinner\Core\Contracts\Frames (interface)](#interface-alecrabbitspinnercorecontractsframes)
- [\AlecRabbit\Spinner\Core\Contracts\Juggler (interface)](#interface-alecrabbitspinnercorecontractsjuggler)
- [\AlecRabbit\Spinner\Core\Contracts\StyleInterface (interface)](#interface-alecrabbitspinnercorecontractsstyleinterface)
- [\AlecRabbit\Spinner\Core\Contracts\Styles (interface)](#interface-alecrabbitspinnercorecontractsstyles)
- [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface (interface)](#interface-alecrabbitspinnercorecontractsspinnerinterface)
- [\AlecRabbit\Spinner\Core\Contracts\OutputInterface (interface)](#interface-alecrabbitspinnercorecontractsoutputinterface)
- [\AlecRabbit\Spinner\Core\Jugglers\MessageJuggler](#class-alecrabbitspinnercorejugglersmessagejuggler)
- [\AlecRabbit\Spinner\Core\Jugglers\FrameJuggler](#class-alecrabbitspinnercorejugglersframejuggler)
- [\AlecRabbit\Spinner\Core\Jugglers\AbstractJuggler (abstract)](#class-alecrabbitspinnercorejugglersabstractjuggler-abstract)
- [\AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler](#class-alecrabbitspinnercorejugglersprogressjuggler)
- [\AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface (interface)](#interface-alecrabbitspinnercorejugglerscontractsjugglerinterface)
- [\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)
- [\AlecRabbit\Spinner\Settings\Property](#class-alecrabbitspinnersettingsproperty)
- [\AlecRabbit\Spinner\Settings\Contracts\SettingsInterface (interface)](#interface-alecrabbitspinnersettingscontractssettingsinterface)
- [\AlecRabbit\Spinner\Settings\Contracts\S (interface)](#interface-alecrabbitspinnersettingscontractss)
- [\AlecRabbit\Spinner\Settings\Contracts\Defaults (interface)](#interface-alecrabbitspinnersettingscontractsdefaults)

<hr />

### Class: \AlecRabbit\Spinner\SnakeSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\PercentSpinner

| Visibility | Function |
|:-----------|:---------|
| public | <strong>begin(</strong><em>\float</em> <strong>$percent=null</strong>)</strong> : <em>void</em> |
| public | <strong>message(</strong><em>\string</em> <strong>$message=null</strong>, <em>\int</em> <strong>$erasingLength=null</strong>)</strong> : <em>void</em> |
| public | <strong>spin(</strong><em>\float</em> <strong>$percent=null</strong>)</strong> : <em>void</em> |

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\ClockSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\BlockSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\DiceSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\WeatherSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\DotSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\MoonSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\BallSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\EarthSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\SimpleSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\ArrowSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\SectorsSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\CircleSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\BouncingBarSpinner

| Visibility | Function |
|:-----------|:---------|

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\TimeSpinner

| Visibility | Function |
|:-----------|:---------|
| public | <strong>begin(</strong><em>\float</em> <strong>$percent=null</strong>)</strong> : <em>void</em> |
| public | <strong>setTimeFormat(</strong><em>\string</em> <strong>$timeFormat</strong>)</strong> : <em>[\AlecRabbit\Spinner\TimeSpinner](#class-alecrabbitspinnertimespinner)</em> |
| public | <strong>spin()</strong> : <em>void</em> |
| protected | <strong>defaultSettings()</strong> : <em>void</em> |

*This class extends [\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\Strip

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>escCodes(</strong><em>\string</em> <strong>$in</strong>)</strong> : <em>string</em> |

<hr />

### Class: \AlecRabbit\Spinner\Core\Sentinel

> Class Sentinel. Contains data asserts

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>assertFrame(</strong><em>mixed</em> <strong>$frame</strong>)</strong> : <em>void</em> |
| public static | <strong>assertFrameLength(</strong><em>\string</em> <strong>$frame</strong>)</strong> : <em>void</em> |
| public static | <strong>assertFrames(</strong><em>array</em> <strong>$frames</strong>)</strong> : <em>void</em> |
| public static | <strong>assertOutput(</strong><em>mixed</em> <strong>$output</strong>)</strong> : <em>void</em> |
| public static | <strong>assertSettings(</strong><em>mixed</em> <strong>$settings</strong>)</strong> : <em>void</em> |
| public static | <strong>assertStyles(</strong><em>array</em> <strong>$styles</strong>, <em>array</em> <strong>$against</strong>)</strong> : <em>void</em> |

<hr />

### Class: \AlecRabbit\Spinner\Core\Spinner (abstract)

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>null/string/\AlecRabbit\Spinner\Core\Settings</em> <strong>$messageOrSettings=null</strong>, <em>null/false/\AlecRabbit\Spinner\Core\OutputInterface</em> <strong>$output=null</strong>, <em>\int</em> <strong>$color=null</strong>)</strong> : <em>void</em><br /><em>Spinner constructor.</em> |
| public | <strong>begin(</strong><em>\float</em> <strong>$percent=null</strong>)</strong> : <em>void</em> |
| public | <strong>end()</strong> : <em>void</em> |
| public | <strong>erase()</strong> : <em>void</em> |
| public | <strong>getOutput()</strong> : <em>mixed</em> |
| public | <strong>inline(</strong><em>\bool</em> <strong>$inline</strong>)</strong> : <em>void</em> |
| public | <strong>interval()</strong> : <em>void</em> |
| public | <strong>last()</strong> : <em>void</em> |
| public | <strong>message(</strong><em>\string</em> <strong>$message=null</strong>, <em>\int</em> <strong>$erasingLength=null</strong>)</strong> : <em>void</em> |
| public | <strong>progress(</strong><em>\float</em> <strong>$percent</strong>)</strong> : <em>void</em> |
| public | <strong>spin()</strong> : <em>void</em> |
| protected | <strong>defaultSettings()</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| protected | <strong>initJugglers()</strong> : <em>void</em> |
| protected | <strong>prepareLastSpinnerString()</strong> : <em>void</em> |
| protected | <strong>refineSettings(</strong><em>null/string/\AlecRabbit\Spinner\Core\Settings</em> <strong>$settings</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| protected | <strong>setMessage(</strong><em>null/string/\string</em> <strong>$message</strong>)</strong> : <em>void</em> |
| protected | <strong>setProgress(</strong><em>\float</em> <strong>$percent=null</strong>)</strong> : <em>void</em> |

*This class extends [\AlecRabbit\Spinner\Core\SpinnerCore](#class-alecrabbitspinnercorespinnercore-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\SpinnerCore (abstract)

| Visibility | Function |
|:-----------|:---------|
| public | <strong>disable()</strong> : <em>void</em> |
| public | <strong>enable()</strong> : <em>void</em> |
| protected | <strong>refineOutput(</strong><em>null/false/\AlecRabbit\Spinner\Core\OutputInterface</em> <strong>$output</strong>)</strong> : <em>null/\AlecRabbit\Spinner\Core\OutputInterface</em> |

*This class implements [\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\Calculator

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>computeErasingLength(</strong><em>null/string/\string</em> <strong>$in</strong>)</strong> : <em>int</em> |
| public static | <strong>computeErasingLengths(</strong><em>array</em> <strong>$strings</strong>)</strong> : <em>int</em> |

<hr />

### Class: \AlecRabbit\Spinner\Core\Adapters\SymfonyOutputAdapter

> Class SymfonyOutputAdapter

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Symfony\Component\Console\Output\OutputInterface</em> <strong>$output</strong>)</strong> : <em>void</em> |
| public | <strong>write(</strong><em>mixed</em> <strong>$messages</strong>, <em>bool</em> <strong>$newline=false</strong>, <em>mixed</em> <strong>$options</strong>)</strong> : <em>void</em> |

*This class implements [\AlecRabbit\Spinner\Core\Contracts\OutputInterface](#interface-alecrabbitspinnercorecontractsoutputinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\Adapters\EchoOutputAdapter

> Class EchoOutputAdapter

| Visibility | Function |
|:-----------|:---------|
| public | <strong>write(</strong><em>mixed</em> <strong>$messages</strong>, <em>bool</em> <strong>$newline=false</strong>, <em>mixed</em> <strong>$options</strong>)</strong> : <em>void</em> |

*This class implements [\AlecRabbit\Spinner\Core\Contracts\OutputInterface](#interface-alecrabbitspinnercorecontractsoutputinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\Coloring\Style

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$styles</strong>, <em>\int</em> <strong>$color</strong>)</strong> : <em>void</em> |
| public | <strong>getFormat()</strong> : <em>mixed</em> |
| public | <strong>getSpacer()</strong> : <em>mixed</em> |
| public | <strong>getStyle()</strong> : <em>mixed</em> |
| protected | <strong>circular256Color(</strong><em>array</em> <strong>$styles</strong>, <em>\string</em> <strong>$format</strong>)</strong> : <em>\AlecRabbit\Accessories\Circular</em> |
| protected | <strong>circularColor(</strong><em>array</em> <strong>$styles</strong>, <em>\string</em> <strong>$format</strong>)</strong> : <em>\AlecRabbit\Accessories\Circular</em> |
| protected | <strong>circularNoColor(</strong><em>\string</em> <strong>$format</strong>)</strong> : <em>\AlecRabbit\Accessories\Circular</em> |
| protected | <strong>makeFormat(</strong><em>\string</em> <strong>$format</strong>)</strong> : <em>string</em> |
| protected | <strong>makeStyle(</strong><em>array</em> <strong>$styles</strong>, <em>null/int/\int</em> <strong>$color</strong>)</strong> : <em>\AlecRabbit\Accessories\Circular</em> |

<hr />

### Class: \AlecRabbit\Spinner\Core\Coloring\Colors

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$styles</strong>, <em>\int</em> <strong>$color=null</strong>)</strong> : <em>void</em> |
| public | <strong>getFrameStyles()</strong> : <em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> |
| public | <strong>getMessageStyles()</strong> : <em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> |
| public | <strong>getProgressStyles()</strong> : <em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> |
| protected | <strong>mergeStyles(</strong><em>array</em> <strong>$styles</strong>)</strong> : <em>array</em> |

<hr />

### Interface: \AlecRabbit\Spinner\Core\Contracts\Frames

| Visibility | Function |
|:-----------|:---------|

<hr />

### Interface: \AlecRabbit\Spinner\Core\Contracts\Juggler

| Visibility | Function |
|:-----------|:---------|

<hr />

### Interface: \AlecRabbit\Spinner\Core\Contracts\StyleInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFormat()</strong> : <em>string</em> |
| public | <strong>getSpacer()</strong> : <em>string</em> |
| public | <strong>getStyle()</strong> : <em>\AlecRabbit\Accessories\Circular</em> |

<hr />

### Interface: \AlecRabbit\Spinner\Core\Contracts\Styles

| Visibility | Function |
|:-----------|:---------|

*This class implements [\AlecRabbit\Spinner\Core\Contracts\Juggler](#interface-alecrabbitspinnercorecontractsjuggler)*

<hr />

### Interface: \AlecRabbit\Spinner\Core\Contracts\SpinnerInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>begin(</strong><em>\float</em> <strong>$percent=null</strong>)</strong> : <em>string</em> |
| public | <strong>disable()</strong> : <em>\AlecRabbit\Spinner\Core\Contracts\self</em> |
| public | <strong>enable()</strong> : <em>\AlecRabbit\Spinner\Core\Contracts\self</em> |
| public | <strong>end()</strong> : <em>string</em> |
| public | <strong>erase()</strong> : <em>string</em> |
| public | <strong>getOutput()</strong> : <em>null/[\AlecRabbit\Spinner\Core\Contracts\OutputInterface](#interface-alecrabbitspinnercorecontractsoutputinterface)</em> |
| public | <strong>inline(</strong><em>\bool</em> <strong>$inline</strong>)</strong> : <em>[\AlecRabbit\Spinner\Core\Contracts\SpinnerInterface](#interface-alecrabbitspinnercorecontractsspinnerinterface)</em> |
| public | <strong>interval()</strong> : <em>float</em> |
| public | <strong>last()</strong> : <em>string</em> |
| public | <strong>message(</strong><em>\string</em> <strong>$message=null</strong>, <em>\int</em> <strong>$erasingLength=null</strong>)</strong> : <em>[\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)</em> |
| public | <strong>progress(</strong><em>null/float/\float</em> <strong>$percent</strong>)</strong> : <em>[\AlecRabbit\Spinner\Core\Spinner](#class-alecrabbitspinnercorespinner-abstract)</em> |
| public | <strong>spin()</strong> : <em>string</em> |

<hr />

### Interface: \AlecRabbit\Spinner\Core\Contracts\OutputInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>write(</strong><em>string/\AlecRabbit\Spinner\Core\Contracts\iterable</em> <strong>$messages</strong>, <em>bool</em> <strong>$newline=false</strong>, <em>int</em> <strong>$options</strong>)</strong> : <em>void</em><br /><em>Writes a message to the output. 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL</em> |

<hr />

### Class: \AlecRabbit\Spinner\Core\Jugglers\MessageJuggler

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> <strong>$settings</strong>, <em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> <strong>$style</strong>)</strong> : <em>void</em> |
| public | <strong>setMessage(</strong><em>\string</em> <strong>$message</strong>)</strong> : <em>void</em> |
| protected | <strong>getCurrentFrame()</strong> : <em>mixed</em> |
| protected | <strong>refineMessage(</strong><em>\string</em> <strong>$message</strong>)</strong> : <em>string</em> |
| protected | <strong>updateMessage(</strong><em>null/string/\string</em> <strong>$message</strong>)</strong> : <em>void</em> |

*This class extends [\AlecRabbit\Spinner\Core\Jugglers\AbstractJuggler](#class-alecrabbitspinnercorejugglersabstractjuggler-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface](#interface-alecrabbitspinnercorejugglerscontractsjugglerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\Jugglers\FrameJuggler

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> <strong>$settings</strong>, <em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> <strong>$style</strong>)</strong> : <em>void</em> |
| protected | <strong>getCurrentFrame()</strong> : <em>string</em> |

*This class extends [\AlecRabbit\Spinner\Core\Jugglers\AbstractJuggler](#class-alecrabbitspinnercorejugglersabstractjuggler-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface](#interface-alecrabbitspinnercorejugglerscontractsjugglerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\Jugglers\AbstractJuggler (abstract)

| Visibility | Function |
|:-----------|:---------|
| public | <strong>abstract __construct(</strong><em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> <strong>$settings</strong>, <em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> <strong>$style</strong>)</strong> : <em>void</em> |
| public | <strong>getFrameErasingLength()</strong> : <em>mixed</em> |
| public | <strong>getStyledFrame()</strong> : <em>mixed</em> |
| protected | <strong>calcFormatErasingShift(</strong><em>\string</em> <strong>$format</strong>)</strong> : <em>int</em> |
| protected | <strong>abstract getCurrentFrame()</strong> : <em>string</em> |
| protected | <strong>init(</strong><em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> <strong>$style</strong>)</strong> : <em>void</em> |

*This class implements [\AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface](#interface-alecrabbitspinnercorejugglerscontractsjugglerinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> <strong>$settings</strong>, <em>[\AlecRabbit\Spinner\Core\Coloring\Style](#class-alecrabbitspinnercorecoloringstyle)</em> <strong>$style</strong>)</strong> : <em>void</em> |
| public | <strong>setProgress(</strong><em>\float</em> <strong>$percent</strong>)</strong> : <em>void</em> |
| protected | <strong>getCurrentFrame()</strong> : <em>mixed</em> |
| protected | <strong>update(</strong><em>null/float/\float</em> <strong>$percent</strong>)</strong> : <em>void</em> |

*This class extends [\AlecRabbit\Spinner\Core\Jugglers\AbstractJuggler](#class-alecrabbitspinnercorejugglersabstractjuggler-abstract)*

*This class implements [\AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface](#interface-alecrabbitspinnercorejugglerscontractsjugglerinterface)*

<hr />

### Interface: \AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFrameErasingLength()</strong> : <em>int</em> |
| public | <strong>getStyledFrame()</strong> : <em>string</em> |

<hr />

### Class: \AlecRabbit\Spinner\Settings\Settings

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>getFrames()</strong> : <em>mixed</em> |
| public | <strong>getInitialPercent()</strong> : <em>mixed</em> |
| public | <strong>getInlinePaddingStr()</strong> : <em>mixed</em> |
| public | <strong>getInterval()</strong> : <em>mixed</em> |
| public | <strong>getMessage()</strong> : <em>mixed</em> |
| public | <strong>getMessageErasingLength()</strong> : <em>mixed</em> |
| public | <strong>getMessageSuffix()</strong> : <em>mixed</em> |
| public | <strong>getSpacer()</strong> : <em>mixed</em> |
| public | <strong>getStyles()</strong> : <em>mixed</em> |
| public | <strong>isEnabled()</strong> : <em>bool</em> |
| public | <strong>merge(</strong><em>\self</em> <strong>$settings</strong>)</strong> : <em>void</em> |
| public | <strong>setEnabled(</strong><em>\bool</em> <strong>$enabled=true</strong>)</strong> : <em>void</em> |
| public | <strong>setFrames(</strong><em>array</em> <strong>$frames</strong>)</strong> : <em>void</em> |
| public | <strong>setInitialPercent(</strong><em>\float</em> <strong>$percent</strong>)</strong> : <em>void</em> |
| public | <strong>setInlinePaddingStr(</strong><em>\string</em> <strong>$inlinePaddingStr</strong>)</strong> : <em>void</em> |
| public | <strong>setInterval(</strong><em>\float</em> <strong>$interval</strong>)</strong> : <em>void</em> |
| public | <strong>setMessage(</strong><em>\string</em> <strong>$message</strong>)</strong> : <em>void</em> |
| public | <strong>setMessageSuffix(</strong><em>\string</em> <strong>$suffix</strong>)</strong> : <em>void</em> |
| public | <strong>setSpacer(</strong><em>\string</em> <strong>$spacer</strong>)</strong> : <em>void</em> |
| public | <strong>setStyles(</strong><em>array</em> <strong>$styles</strong>)</strong> : <em>void</em> |

*This class implements [\AlecRabbit\Spinner\Settings\Contracts\SettingsInterface](#interface-alecrabbitspinnersettingscontractssettingsinterface)*

<hr />

### Class: \AlecRabbit\Spinner\Settings\Property

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$defaultValue=null</strong>)</strong> : <em>void</em><br /><em>SettingsValue constructor.</em> |
| public | <strong>getValue()</strong> : <em>mixed</em> |
| public | <strong>isDefault()</strong> : <em>bool</em> |
| public | <strong>isNotDefault()</strong> : <em>bool</em> |
| public | <strong>setValue(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

<hr />

### Interface: \AlecRabbit\Spinner\Settings\Contracts\SettingsInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getFrames()</strong> : <em>array</em> |
| public | <strong>getInitialPercent()</strong> : <em>null/float</em> |
| public | <strong>getInlinePaddingStr()</strong> : <em>string</em> |
| public | <strong>getInterval()</strong> : <em>float</em> |
| public | <strong>getMessage()</strong> : <em>null/string</em> |
| public | <strong>getMessageErasingLength()</strong> : <em>int</em> |
| public | <strong>getMessageSuffix()</strong> : <em>string</em> |
| public | <strong>getSpacer()</strong> : <em>string</em> |
| public | <strong>getStyles()</strong> : <em>array</em> |
| public | <strong>isEnabled()</strong> : <em>bool</em> |
| public | <strong>merge(</strong><em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> <strong>$settings</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setEnabled(</strong><em>\bool</em> <strong>$enabled=true</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setFrames(</strong><em>array</em> <strong>$frames</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setInitialPercent(</strong><em>null/float/\float</em> <strong>$percent</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setInlinePaddingStr(</strong><em>\string</em> <strong>$inlinePaddingStr</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setInterval(</strong><em>\float</em> <strong>$interval</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setMessage(</strong><em>\string</em> <strong>$message</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setMessageSuffix(</strong><em>\string</em> <strong>$suffix</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setSpacer(</strong><em>\string</em> <strong>$spacer</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |
| public | <strong>setStyles(</strong><em>array</em> <strong>$styles</strong>)</strong> : <em>[\AlecRabbit\Spinner\Settings\Settings](#class-alecrabbitspinnersettingssettings)</em> |

<hr />

### Interface: \AlecRabbit\Spinner\Settings\Contracts\S

| Visibility | Function |
|:-----------|:---------|

<hr />

### Interface: \AlecRabbit\Spinner\Settings\Contracts\Defaults

| Visibility | Function |
|:-----------|:---------|

