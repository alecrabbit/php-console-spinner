```mermaid
classDiagram
direction TB
class ACharFrame {
   __construct(char, width) 
    char
    width
   __toString() 
   createEmpty() 
   getWidth() 
   create(char, width) 
   getChar() 
   createSpace() 
}
class ACharFrameCollection {
   next() 
   getElementClass() 
   create(frames, interval) 
}
class ACharFrameCollectionFactory {
   __construct(charProvider) 
    charProvider
   create(charPattern) 
}
class ACharFrameFactory {
   create(char, width) 
}
class ACharRevolver {
   __construct(collection) 
    collection
   next() 
}
class ACollection {
   __construct(elements) 
    elements
    count
    index
   assertIsNotEmpty() 
   next() 
   getIterator() 
   getElementClass() 
   assertElement(element, class) 
   count() 
   addElement(element) 
}
class AContainer {
   __construct(interval, intervalVisitor, wasCreatedEmpty) 
    intervalVisitor
    progressContext
    contextsMap
    messageContext
    index
    interval
    contexts
    spinnerContext
    cycle
    wasCreatedEmpty
   render() 
   remove(element) 
   message(twirler) 
   getIntervalVisitor() 
   progress(twirler) 
   add(twirler) 
   wasCreatedEmpty() 
   spinner(twirler) 
   getIntervalComponents() 
   assertIsNotMulti() 
   getCycleVisitor() 
}
class ADefaults {
    MILLISECONDS_MAX_INTERVAL
    MILLISECONDS_INTERVAL
    MAX_WIDTH
    MAX_SHUTDOWN_DELAY
    HIDE_CURSOR
    FINAL_MESSAGE
    MODE_IS_SYNCHRONOUS
    PROGRESS_FORMAT
    SHUTDOWN_DELAY
    COLOR_SUPPORT_LEVELS
    MILLISECONDS_MIN_INTERVAL
    MESSAGE_ON_EXIT
    INTERRUPT_MESSAGE
   __construct() 
}
class AIntervalCollection {
   __construct(elements, interval) 
    interval
    cycle
   acceptIntervalVisitor(intervalVisitor) 
   setCycle(cycle) 
   acceptCycleVisitor(cycleVisitor) 
   getIntervalComponents() 
}
class AMultiSpinner {
   remove(element) 
   add(twirler) 
}
class ARevolver {
   __construct(interval) 
    interval
    currentElement
    cycle
   next() 
   getIntervalComponents() 
}
class ASimpleSpinner {
   __construct(config) 
    twirlerFactory
   message(element) 
   progress(element) 
   spinner(value) 
}
class ASpinner {
   __construct(config) 
    container
    driver
    currentWidth
    finalMessage
    active
    interruptMessage
    interrupted
   erase() 
   acceptIntervalVisitor(intervalVisitor) 
   initialize() 
   setCycle(cycle) 
   getInterval() 
   deactivate() 
   spin() 
   wrap(callback, args) 
   activate() 
   finalize() 
   stop() 
   acceptCycleVisitor(cycleVisitor) 
   getIntervalComponents() 
   recalculate() 
   interrupt() 
}
class ASpinnerFactory {
   refineConfig(config) 
   initializeSpinner(spinner, config) 
   create(config) 
   createMultiSpinner(config) 
   createSpinner(config) 
   fillSpinner(spinner, config) 
}
class AStyleFrame {
   __construct(sequenceStart, sequenceEnd) 
    sequenceStart
    sequenceEnd
   getSequenceEnd() 
   createEmpty() 
   getSequenceStart() 
}
class AStyleFrameCollection {
   next() 
   getElementClass() 
   create(frames, interval) 
}
class AStyleFrameCollectionFactory {
   __construct(styleProvider) 
    styleProvider
   create(stylePattern) 
}
class AStyleFrameFactory {
   create(item, format) 
}
class AStyleRevolver {
   __construct(collection) 
    collection
   next() 
}
class ATwirler {
   __construct(styleRevolver, charRevolver, leadingSpacer, trailingSpacer) 
    charRevolver
    leadingSpacer
    trailingSpacer
    currentFrame
    interval
    styleRevolver
    cycle
   render() 
   getIntervalComponents() 
}
class ATwirlerBuilder {
    STYLE
    CHAR
    REVOLVER
    ERROR_MESSAGE_FORMAT
    FRAME_COLLECTION
    PATTERN
    FRAME_COLLECTION_FACTORY
   __construct(styleFrameCollectionFactory, charFrameCollectionFactory) 
    styleFrameCollection
    styleFrameCollectionFactory
    charFrameCollectionFactory
    charRevolver
    leadingSpacer
    charFrameCollection
    stylePattern
    charPattern
    trailingSpacer
    styleRevolver
   assertForCharRevolver(builder, methodName) 
   noLeadingSpacer() 
   assertForCharFrameCollectionFactory(builder, methodName) 
   assertState(builder) 
   assertForStyleFrameCollectionFactory(builder, methodName) 
   withCharCollection(charCollection) 
   assertForCharPattern(builder, methodName) 
   withCharRevolver(charRevolver) 
   withLeadingSpacer(leadingSpacer) 
   withStyleRevolver(styleRevolver) 
   withCharPattern(charPattern) 
   withStylePattern(stylePattern) 
   withStyleFrameCollectionFactory(styleFrameCollectionFactory) 
   withStyleCollection(styleCollection) 
   withCharFrameCollectionFactory(charFrameCollectionFactory) 
   assertForStyleCollection(builder, methodName) 
   withTrailingSpacer(trailingSpacer) 
   assertForStyleRevolver(builder, methodName) 
   assertForStylePattern(builder, methodName) 
   assertForCharCollection(builder, methodName) 
   getException(methodName, kind, type, auxMessage) 
   processDefaults() 
   noTrailingSpacer() 
   build() 
}
class ATwirlerContext {
   __construct(twirler) 
    interval
    twirler
    cycle
   render() 
   getTwirler() 
   getIntervalComponents() 
   setTwirler(twirler) 
}
class ATwirlerFactory {
   __construct(twirlerBuilder) 
    twirlerBuilder
   message(message) 
   progress(progress) 
   spinner() 
}
class ATwirlerFrame {
   __construct(styleFrame, charFrame, leadingSpacer, trailingSpacer) 
    leadingSpacer
    charFrame
    styleFrame
    trailingSpacer
   getLeadingSpacer() 
   getTrailingSpacer() 
   getCharFrame() 
   getStyleFrame() 
}
class C {
    INTERVAL
    COLLECTION
    FORMAT
    STYLE
    CHAR
    ELEMENT_WIDTH
    STYLES
    WIDTH
    CHARS
    FRAME
    REVOLVER
    STR_PLACEHOLDER
    FRAMES
    PATTERN
    EMPTY_STRING
    SEQUENCE
    SPACE_CHAR
    ELEMENT_LENGTH
    DEFAULT_MESSAGE
    FACTORY
   __construct() 
}
class CanAcceptCycleVisitor {
   setCycle(cycle) 
   acceptCycleVisitor(cycleVisitor) 
}
class CanAcceptIntervalVisitor {
   acceptIntervalVisitor(intervalVisitor) 
}
class CanAddTwirler {
   addTwirler(twirler) 
}
class CharFrame
class CharFrameCollection
class CharFrameCollectionFactory
class CharFrameFactory
class CharPattern {
    EARTH
    DOT_8_BIT
    DIAMOND
    DICE
    BLOCK_VARIANT_2
    BLOCK_VARIANT_1
    RUNNER
    BLOCK_VARIANT_0
    WEATHER_VARIANT_0
    WEATHER_VARIANT_1
    DOTS_VARIANT_3
    DOTS_VARIANT_4
    DOTS_VARIANT_5
    BALL_VARIANT_0
    DOTS_VARIANT_2
    ARROWS
    CLOCK_VARIANT_1
    CLOCK_VARIANT_2
    ARROWS_VARIANT_4
    ARROWS_VARIANT_5
    CLOCK_VARIANT_0
    MOON
    SNAKE_VARIANT_3
    SNAKE_VARIANT_2
    SNAKE_VARIANT_1
    SECTOR
    DOT
    SNAKE_VARIANT_0
    BOUNCE
    SQUARE_VARIANT_1
    TOGGLE_VARIANT_0
    SQUARE_VARIANT_0
    TOGGLE_VARIANT_1
    MONKEY
    ARROW_VARIANT_3
    MOON_REVERSED
    CIRCLES
    ARROW_VARIANT_2
    BOUNCING_BAR_VARIANT_1
    ARROW_VARIANT_1
    BOUNCING_BAR_VARIANT_2
    ARROW_VARIANT_0
    BOUNCING_BAR_VARIANT_3
    SIMPLE
    TREE
    DOT_REVERSED
    FEATHERED_ARROWS
    TRIGRAM
   __construct() 
   none() 
}
class CharPatternExtractor {
   assertCharPattern(charPattern) 
   extract(charPattern) 
}
class CharProvider {
   __construct(charFactory, extractor) 
    extractor
    charFactory
   provide(charPattern) 
   getDefaultCharPattern() 
}
class CharRevolver
class CharRevolverFactory {
   __construct(charFrameCollectionFactory) 
    charFrameCollectionFactory
   create(frameCollection) 
}
class Config {
   __construct(driver, container, twirlerFactory, twirlerBuilder, styleFrameCollectionFactory, charFrameCollectionFactory, shutdownDelay, interruptMessage, finalMessage, synchronous, loop, colorSupportLevel, createInitialized, spinnerStylePattern, spinnerCharPattern, spinnerTrailingSpacer) 
    container
    spinnerCharPattern
    finalMessage
    synchronous
    styleFrameCollectionFactory
    interruptMessage
    charFrameCollectionFactory
    driver
    createInitialized
    loop
    colorSupportLevel
    spinnerStylePattern
    twirlerBuilder
    shutdownDelay
    spinnerTrailingSpacer
    twirlerFactory
   assert() 
   synchronousModeException(reason) 
   getContainer() 
   assertShutdownDelay() 
   assertColorSupportLevel() 
   getTwirlerFactory() 
   createInitialized() 
   getSpinnerStylePattern() 
   getInterruptMessage() 
   getShutdownDelay() 
   forMultiSpinner() 
   getSpinnerCharPattern() 
   getFinalMessage() 
   getTwirlerBuilder() 
   assertRunMode() 
   assertExitMessage() 
   getDriver() 
   isSynchronous() 
   getCharFrameCollectionFactory() 
   assertInterruptMessage() 
   getColorSupportLevel() 
   getLoop() 
   getSpinnerTrailingSpacer() 
   isAsynchronous() 
   getStyleFrameCollectionFactory() 
}
class ConfigBuilder {
    container
    intervalVisitor
    charProvider
    spinnerCharPattern
    containerFactory
    finalMessage
    charPatternExtractor
    shutdownDelaySeconds
    interruptMessage
    terminalColorSupport
    createEmpty
    stylePatternExtractor
    createInitialized
    hideCursor
    loop
    spinnerStylePattern
    spinnerTrailingSpacer
    twirlerFactory
    loopFactory
    styleFrameCollectionFactory
    charFrameCollectionFactory
    synchronousMode
    styleProvider
    driver
    twirlerBuilder
    interval
   withIntervalVisitor(intervalVisitor) 
   withFinalMessage(finalMessage) 
   withLoopFactory(loopFactory) 
   withContainer(container) 
   withTwirlerFactory(twirlerFactory) 
   createEmpty() 
   inSynchronousMode() 
   withInterruptMessage(interruptMessage) 
   createLoopFactory() 
   withShutdownDelay(microseconds) 
   createInitialized() 
   withLoop(loop) 
   createDriver() 
   withStyleFrameCollectionFactory(styleFrameCollectionFactory) 
   withContainerFactory(containerFactory) 
   withCharFrameCollectionFactory(charFrameCollectionFactory) 
   withCursor() 
   withTerminalColor(terminalColorSupport) 
   withCharProvider(charProvider) 
   withTwirlerBuilder(twirlerBuilder) 
   withStylePatternExtractor(stylePatternExtractor) 
   processDefaults() 
   getLoop(synchronousMode) 
   withDriver(driver) 
   withCharPatternExtractor(charPatternExtractor) 
   withStyleProvider(styleProvider) 
   withInterval(interval) 
   build() 
}
class Container
class ContextAware {
    context
   setContext(context) 
}
class Countable {
   count() 
}
class Cycle {
   __construct(total) 
    current
    num
   refine(total) 
   completed() 
}
class CycleCalculator {
   calculate(preferredInterval, interval) 
}
class CycleVisitor {
   __construct(interval) 
    interval
   visit(container) 
}
class Defaults {
    colorSupportLevels
    defaultCharPattern
    maxIntervalMilliseconds
    spinnerCharPattern
    isModeSynchronous
    finalMessage
    maxShutdownDelay
    interruptMessage
    messageOnExit
    hideCursor
    spinnerStylePattern
    shutdownDelay
    minIntervalMilliseconds
    spinnerTrailingSpacer
    progressFormat
    defaultStylePattern
   setColorSupportLevels(colorSupportLevels) 
   setMessageOnExit(messageOnExit) 
   setSpinnerTrailingSpacer(spinnerTrailingSpacer) 
   reset() 
   getDefaultStylePattern() 
   setFinalMessage(finalMessage) 
   setMinIntervalMilliseconds(minIntervalMilliseconds) 
   setSpinnerCharPattern(spinnerCharPattern) 
   getSpinnerStylePattern() 
   getHideCursor() 
   setShutdownDelay(shutdownDelay) 
   getInterruptMessage() 
   getMaxShutdownDelay() 
   setHideCursor(hideCursor) 
   getMaxIntervalMilliseconds() 
   getShutdownDelay() 
   getProgressFormat() 
   isModeSynchronous() 
   getSpinnerCharPattern() 
   setSpinnerStylePattern(spinnerStylePattern) 
   getFinalMessage() 
   getMessageOnExit() 
   setDefaultCharPattern(char) 
   setDefaultStylePattern(style) 
   assertColorSupportLevels(colorSupportLevels) 
   getDefaultCharPattern() 
   setModeAsSynchronous(isModeSynchronous) 
   setProgressFormat(progressFormat) 
   setMaxShutdownDelay(maxShutdownDelay) 
   getSpinnerTrailingSpacer() 
   getMinIntervalMilliseconds() 
   setInterruptMessage(interruptMessage) 
   setMaxIntervalMilliseconds(maxIntervalMilliseconds) 
   getColorSupportLevels() 
}
class DomainException
class Driver {
   __construct(hideCursor, writer, renderer) 
    renderer
    hideCursor
    writer
   erase(i) 
   message(message) 
   showCursor() 
   getTerminalColorSupport() 
   hideCursor() 
   display(sequence) 
}
class Exception {
   __construct(message, code, previous) 
    code
    file
    line
    message
   __toString() 
   getCode() 
   getFile() 
   __wakeup() 
   getPrevious() 
   __clone() 
   getLine() 
   getMessage() 
   getTrace() 
   getTraceAsString() 
}
class HasInterval {
   getInterval() 
}
class HasMethodGetInterval {
   getInterval() 
}
class ICharFrame {
   getWidth() 
   getChar() 
}
class ICharFrameCollection {
   next() 
   create(frames, interval) 
}
class ICharFrameCollectionFactory {
   create(charPattern) 
}
class ICharFrameFactory {
   create(char, width) 
}
class ICharPatternExtractor {
   extract(charPattern) 
}
class ICharProvider {
   provide(charPattern) 
}
class ICharRevolver
class ICharRevolverFactory {
   create() 
}
class ICollection
class IConfig {
   getContainer() 
   getFinalMessage() 
   getTwirlerBuilder() 
   getTwirlerFactory() 
   getDriver() 
   getSpinnerStylePattern() 
   createInitialized() 
   isSynchronous() 
   getCharFrameCollectionFactory() 
   getInterruptMessage() 
   getColorSupportLevel() 
   getLoop() 
   getSpinnerTrailingSpacer() 
   getShutdownDelay() 
   isAsynchronous() 
   getSpinnerCharPattern() 
   getStyleFrameCollectionFactory() 
   forMultiSpinner() 
}
class IConfigBuilder {
   build() 
}
class IContainer {
   remove(element) 
   render() 
   message(twirler) 
   getIntervalVisitor() 
   progress(twirler) 
   wasCreatedEmpty() 
   spinner(twirler) 
   add(twirler) 
   getCycleVisitor() 
}
class IContextAware {
   setContext(context) 
}
class ICycle {
   completed() 
}
class ICycleVisitor {
   visit(container) 
}
class IDriver {
   erase(i) 
   message(message) 
   showCursor() 
   getTerminalColorSupport() 
   hideCursor() 
   display(sequence) 
}
class IInterval {
   createDefault() 
   toMicroseconds() 
   smallest(other) 
   toMilliseconds() 
   toSeconds() 
}
class IIntervalComponent {
   acceptIntervalVisitor(intervalVisitor) 
   setCycle(cycle) 
   acceptCycleVisitor(cycleVisitor) 
   getIntervalComponents() 
}
class IIntervalVisitor {
   visit(container) 
}
class ILoop {
   removeHandler(signal, callback) 
   stop() 
   addHandler(signal, callback) 
   defer(interval, callback) 
   periodic(interval, callback) 
}
class ILoopFactory {
   supported() 
   getLoop() 
}
class ILoopProbe {
   getPackageName() 
   isSupported() 
   getLoop() 
}
class IMessage
class IMultiSpinner {
   remove(element) 
   add(twirler) 
}
class IOutput {
   writeln(messages, options) 
   write(messages, newline, options) 
}
class IProgress
class IRenderer {
   display(twirlers) 
}
class IRevolver
class ISequencer {
   colorSequenceStart(sequence) 
   colorSequenceEnd() 
   hideCursorSequence() 
   moveBackSequence(i) 
   showCursorSequence() 
   eraseSequence(i) 
   colorSequence(sequence) 
}
class ISimpleSpinner {
   message(element) 
   progress(element) 
   spinner(value) 
}
class ISpinner {
   erase() 
   interrupt() 
   initialize() 
   deactivate() 
   spin() 
   wrap(callback, args) 
   activate() 
   finalize() 
}
class ISpinnerFactory {
   create(config) 
}
class IStrSplitter {
   split(s, length) 
}
class IStyleFrame {
   getSequenceEnd() 
   createEmpty() 
   getSequenceStart() 
}
class IStyleFrameCollection {
   next() 
   create(frames, interval) 
}
class IStyleFrameCollectionFactory {
   create(stylePattern) 
}
class IStyleFrameFactory {
   create(item, format) 
}
class IStylePatternExtractor {
   extract(stylePattern) 
}
class IStyleProvider {
   provide(stylePattern) 
}
class IStyleRevolver
class IStyleRevolverFactory {
   create(styleCollection) 
}
class ITerminal
class ITwirler {
   render() 
}
class ITwirlerBuilder {
   noLeadingSpacer() 
   withTrailingSpacer(trailingSpacer) 
   withCharCollection(charCollection) 
   withCharRevolver(charRevolver) 
   withLeadingSpacer(leadingSpacer) 
   withStyleRevolver(styleRevolver) 
   noTrailingSpacer() 
   withStyleFrameCollectionFactory(styleFrameCollectionFactory) 
   withStylePattern(stylePattern) 
   withStyleCollection(styleCollection) 
   withCharFrameCollectionFactory(charFrameCollectionFactory) 
   withCharPattern(charPattern) 
   build() 
}
class ITwirlerContainerFactory {
   createContainer(asMulti) 
}
class ITwirlerContext {
   render() 
   getTwirler() 
   setTwirler(twirler) 
}
class ITwirlerFactory {
   message(message) 
   progress(progress) 
   spinner() 
}
class ITwirlerFrame {
   getLeadingSpacer() 
   getTrailingSpacer() 
   getCharFrame() 
   getStyleFrame() 
}
class IWidthDefiner {
   define(elements) 
}
class IWriter {
   getOutput() 
   write(sequences) 
}
class Interval {
   __construct(milliseconds) 
    milliseconds
    minInterval
    maxInterval
   assert(interval) 
   createDefault() 
   toMicroseconds() 
   smallest(other) 
   minInterval() 
   maxInterval() 
   toMilliseconds() 
   toSeconds() 
}
class IntervalVisitor {
   visit(container) 
}
class InvalidArgumentException
class IteratorAggregate {
   getIterator() 
}
class LogicException
class LoopFactory {
    DEFAULT_PROBES
   __construct(loopProbes) 
    loopProbes
    supportedPackages
   getNoLoopException() 
   supported() 
   addLoopProbe(class) 
   getLoop() 
}
class MethodNotImplementedException
class MultiSpinner
class MultiSpinnerFactory {
   create(config) 
}
class ReactLoopAdapter {
   __construct(loop) 
    instance
    loop
   removeHandler(signal, callback) 
   stop() 
   getPackageName() 
   addHandler(signal, callback) 
   isSupported() 
   getLoop() 
   defer(interval, callback) 
   periodic(interval, callback) 
}
class Renderable
class RuntimeException
class Sequencer {
    SEQ_HIDE_CURSOR
    SEQ_SHOW_CURSOR
   colorSequenceStart(sequence) 
   colorSequenceEnd() 
   hideCursorSequence() 
   moveBackSequence(i) 
   showCursorSequence() 
   eraseSequence(i) 
   colorSequence(sequence) 
}
class SimpleSpinner
class SimpleSpinnerFactory {
   create(config) 
}
class StrSplitter {
   split(s, length) 
}
class StreamOutput {
   __construct(stream) 
    stream
   write(messages, newline, options) 
   writeln(messages, options) 
   assertStream(stream) 
}
class Stringable {
   __toString() 
}
class StyleFrame
class StyleFrameCollection
class StyleFrameCollectionFactory
class StyleFrameFactory
class StylePattern {
    SEQUENCE_RAINBOW
   rainbow() 
   rainbowBg() 
   none() 
   red() 
   defaults() 
   fillWithDefaults(incoming, defaults) 
}
class StylePatternExtractor {
    DEFAULT_COLOR_SUPPORT
   __construct(terminalColorSupport) 
    terminalColorSupport
   assertStylePattern(stylePattern) 
   extractStylePatternMaxColorSupport(pattern) 
   extract(stylePattern) 
}
class StyleProvider {
   __construct(frameFactory, extractor) 
    extractor
    frameFactory
   provide(stylePattern) 
   getDefaultStylePattern() 
}
class StyleRevolver
class StyleRevolverFactory {
   __construct(styleFrameCollectionFactory) 
    styleFrameCollectionFactory
   create(styleCollection) 
}
class Throwable {
   __toString() 
   getCode() 
   getFile() 
   getPrevious() 
   getLine() 
   getMessage() 
   getTrace() 
   getTraceAsString() 
}
class Traversable
class Twirler
class TwirlerBuilder
class TwirlerContainerFactory {
   __construct(interval, intervalVisitor, twirlerFactory) 
    intervalVisitor
    interval
    twirlerFactory
   createContainer(asMulti) 
}
class TwirlerContext
class TwirlerFactory
class TwirlerFrame
class TwirlerRenderer {
   __construct(output) 
    output
   display(twirlers) 
}
class WidthDefiner {
   define(elements) 
   defineWidth(element) 
}
class Writer {
   __construct(output) 
    output
   getOutput() 
   write(sequences) 
}
class iterable

ACharFrame  ..>  ICharFrame 
ACharFrame  ..>  Stringable 
ACharFrameCollection  -->  AIntervalCollection 
ACharFrameCollection  ..>  ICharFrameCollection 
ACharFrameCollectionFactory  ..>  ICharFrameCollectionFactory 
ACharFrameFactory  ..>  ICharFrameFactory 
ACharRevolver  -->  ARevolver 
ACharRevolver  ..>  ICharRevolver 
ACollection  ..>  Countable 
ACollection  ..>  IteratorAggregate 
AContainer  ..>  CanAcceptCycleVisitor 
AContainer  ..>  CanAcceptIntervalVisitor 
AContainer  ..>  HasMethodGetInterval 
AContainer  ..>  IContainer 
AIntervalCollection  -->  ACollection 
AIntervalCollection  ..>  HasMethodGetInterval 
AIntervalCollection  ..>  IIntervalComponent 
AMultiSpinner  -->  ASpinner 
AMultiSpinner  ..>  IMultiSpinner 
ARevolver  ..>  CanAcceptCycleVisitor 
ARevolver  ..>  CanAcceptIntervalVisitor 
ARevolver  ..>  HasMethodGetInterval 
ARevolver  ..>  IRevolver 
ASimpleSpinner  -->  ASpinner 
ASimpleSpinner  ..>  ISimpleSpinner 
ASpinner  ..>  IIntervalComponent 
ASpinner  ..>  ISpinner 
ASpinnerFactory  ..>  ISpinnerFactory 
AStyleFrame  ..>  IStyleFrame 
AStyleFrameCollection  -->  AIntervalCollection 
AStyleFrameCollection  ..>  IStyleFrameCollection 
AStyleFrameFactory  ..>  IStyleFrameFactory 
AStyleRevolver  -->  ARevolver 
AStyleRevolver  ..>  IStyleRevolver 
ATwirler  ..>  CanAcceptCycleVisitor 
ATwirler  ..>  CanAcceptIntervalVisitor 
ATwirler  ..>  ContextAware 
ATwirler  ..>  HasMethodGetInterval 
ATwirler  ..>  ITwirler 
ATwirlerBuilder  ..>  ITwirlerBuilder 
ATwirlerContext  ..>  CanAcceptCycleVisitor 
ATwirlerContext  ..>  CanAcceptIntervalVisitor 
ATwirlerContext  ..>  HasMethodGetInterval 
ATwirlerContext  ..>  IIntervalComponent 
ATwirlerContext  ..>  ITwirlerContext 
ATwirlerFactory  ..>  ITwirlerFactory 
ATwirlerFrame  ..>  ITwirlerFrame 
CharFrame  -->  ACharFrame 
CharFrameCollection  -->  ACharFrameCollection 
CharFrameCollectionFactory  -->  ACharFrameCollectionFactory 
CharFrameFactory  -->  ACharFrameFactory 
CharPatternExtractor  ..>  ICharPatternExtractor 
CharProvider  ..>  ICharProvider 
CharRevolver  -->  ACharRevolver 
CharRevolverFactory  ..>  ICharRevolverFactory 
Config  ..>  IConfig 
ConfigBuilder  ..>  IConfigBuilder 
Container  -->  AContainer 
Cycle  ..>  ICycle 
CycleVisitor  ..>  ICycleVisitor 
Defaults  -->  ADefaults 
DomainException  -->  LogicException 
Driver  ..>  IDriver 
Exception  ..>  Throwable 
ICharFrameCollection  -->  ICollection 
ICharFrameCollection  -->  IIntervalComponent 
ICollection  -->  Countable 
ICollection  -->  IteratorAggregate 
IContainer  -->  IIntervalComponent 
IIntervalComponent  -->  HasInterval 
IRevolver  -->  IIntervalComponent 
IStyleFrameCollection  -->  HasInterval 
IStyleFrameCollection  -->  ICollection 
ITwirler  -->  IContextAware 
ITwirler  -->  IIntervalComponent 
ITwirler  -->  Renderable 
ITwirlerContext  -->  Renderable 
Interval  ..>  IInterval 
IntervalVisitor  ..>  IIntervalVisitor 
InvalidArgumentException  -->  RuntimeException 
IteratorAggregate  -->  Traversable 
LogicException  -->  Exception 
LoopFactory  ..>  ILoopFactory 
MethodNotImplementedException  -->  RuntimeException 
MultiSpinner  -->  AMultiSpinner 
MultiSpinnerFactory  -->  ASpinnerFactory 
ReactLoopAdapter  ..>  ILoop 
ReactLoopAdapter  ..>  ILoopProbe 
RuntimeException  -->  Exception 
Sequencer  ..>  ISequencer 
SimpleSpinner  -->  ASimpleSpinner 
SimpleSpinnerFactory  -->  ASpinnerFactory 
StrSplitter  ..>  IStrSplitter 
StreamOutput  ..>  IOutput 
StyleFrame  -->  AStyleFrame 
StyleFrameCollection  -->  AStyleFrameCollection 
StyleFrameCollectionFactory  -->  AStyleFrameCollectionFactory 
StyleFrameCollectionFactory  ..>  IStyleFrameCollectionFactory 
StyleFrameFactory  -->  AStyleFrameFactory 
StylePatternExtractor  ..>  IStylePatternExtractor 
StyleProvider  ..>  IStyleProvider 
StyleRevolver  -->  AStyleRevolver 
StyleRevolverFactory  ..>  IStyleRevolverFactory 
Throwable  -->  Stringable 
Traversable  -->  iterable 
Twirler  -->  ATwirler 
TwirlerBuilder  -->  ATwirlerBuilder 
TwirlerContainerFactory  ..>  ITwirlerContainerFactory 
TwirlerContext  -->  ATwirlerContext 
TwirlerFactory  -->  ATwirlerFactory 
TwirlerFrame  -->  ATwirlerFrame 
TwirlerRenderer  ..>  IRenderer 
WidthDefiner  ..>  IWidthDefiner 
Writer  ..>  IWriter 
```
